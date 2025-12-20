<?php

namespace App\Exports;

use App\Models\PresensiModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class PresensiExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    protected $start_date, $end_date, $holidayDates = [], $jamKerja, $period;

    public function __construct($start_date, $end_date)
    {
        Carbon::setLocale('id');
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->jamKerja = DB::table('jam_kerja')->where('is_active', true)->first();
        $this->period = CarbonPeriod::create($start_date, $end_date);

        try {
            $year = Carbon::parse($start_date)->year;
            $response = Http::get("https://api-harilibur.vercel.app/api?year={$year}");
            if ($response->successful()) {
                $this->holidayDates = collect($response->json())
                    ->filter(fn($d) => $d['is_national_holiday'])
                    ->pluck('holiday_date')->toArray();
            }
        } catch (\Exception $e) {
            $this->holidayDates = [];
        }
    }

    public function headings(): array
    {
        $header = ['NAMA PEGAWAI'];
        foreach ($this->period as $date) {
            $header[] = 'MASUK';
            $header[] = 'KELUAR';
        }

        return array_merge($header, [
            'HADIR/TEPAT WAKTU (M)',
            'TERLAMBAT (M)',
            'TIDAK HADIR (M)',
            'HADIR/TEPAT WAKTU (K)',
            'TIDAK ABSEN (K)',
            'LUPA ABSEN PULANG',
            'TOTAL KEHADIRAN'
        ]);
    }

    public function collection()
    {
        $users = User::where('role', 'pegawai')->get();
        $fullData = collect();
        $dayMapping = [0 => 'minggu_kerja', 1 => 'senin_kerja', 2 => 'selasa_kerja', 3 => 'rabu_kerja', 4 => 'kamis_kerja', 5 => 'jumat_kerja', 6 => 'sabtu_kerja'];

        foreach ($users as $user) {
            $row = [$user->name];

            // Inisialisasi Counter dengan 0
            $stats = [
                'm_hadir' => 0,
                'm_telat' => 0,
                'm_alpha' => 0,
                'k_hadir' => 0,
                'k_alpha' => 0,
                'lupa_pulang' => 0,
                'total_hadir' => 0
            ];

            $presensiData = PresensiModel::where('id_user', $user->id)
                ->whereBetween('tanggal', [$this->start_date, $this->end_date])
                ->get()->keyBy('tanggal');

            foreach ($this->period as $date) {
                $dateStr = $date->toDateString();
                $dayColumn = $dayMapping[$date->dayOfWeek];
                $isHariKerja = $this->jamKerja ? (bool) $this->jamKerja->$dayColumn : !$date->isWeekend();
                $isHoliday = in_array($dateStr, $this->holidayDates);
                $isOff = !$isHariKerja || $isHoliday;

                if (isset($presensiData[$dateStr])) {
                    $p = $presensiData[$dateStr];

                    // Rekap Masuk
                    if ($p->status_masuk === 'tepat_waktu') $stats['m_hadir']++;
                    elseif ($p->status_masuk === 'terlambat') $stats['m_telat']++;
                    elseif ($p->status_masuk === 'tidak_absen') $stats['m_alpha']++;

                    // Rekap Keluar (Pulang Cepat digabung ke Hadir atau Tepat Waktu sesuai kebutuhan umum)
                    if ($p->status_keluar === 'tepat_waktu' || $p->status_keluar === 'pulang_cepat') {
                        $stats['k_hadir']++;
                    } elseif ($p->status_keluar === 'tidak_absen') {
                        $stats['k_alpha']++;
                    }

                    // Logika Lupa Pulang: Ada Jam Masuk tapi Jam Keluar Kosong ATAU status tidak_absen
                    if (!is_null($p->jam_masuk) && (is_null($p->jam_keluar) || $p->status_keluar === 'tidak_absen')) {
                        $stats['lupa_pulang']++;
                    }

                    // Total Kehadiran (Apapun yang penting ada jam masuk)
                    if (!is_null($p->jam_masuk)) $stats['total_hadir']++;

                    $row[] = ($p->jam_masuk ? substr($p->jam_masuk, 0, 5) : '--:--') . ' [' . str_replace('_', ' ', strtoupper($p->status_masuk ?? 'TIDAK ABSEN')) . ']';
                    $row[] = ($p->jam_keluar ? substr($p->jam_keluar, 0, 5) : '--:--') . ' [' . str_replace('_', ' ', strtoupper($p->status_keluar ?? 'TIDAK ABSEN')) . ']';
                } else {
                    $label = $isHoliday ? 'LIBUR' : ($isOff ? 'OFF' : 'TIDAK ABSEN');
                    if (!$isOff) $stats['m_alpha']++;
                    $row[] = $label;
                    $row[] = $label;
                }
            }

            // Gabungkan hasil rekap (otomatis angka 0 jika tidak ada data)
            $row[] = $stats['m_hadir'];
            $row[] = $stats['m_telat'];
            $row[] = $stats['m_alpha'];
            $row[] = $stats['k_hadir'];
            $row[] = $stats['k_alpha'];
            $row[] = $stats['lupa_pulang'];
            $row[] = $stats['total_hadir'];

            $fullData->push($row);
        }
        return $fullData;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            2 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $highestCol = $sheet->getHighestColumn();
                $highestRow = $sheet->getHighestRow();

                // Header Tanggal
                $sheet->insertNewRowBefore(1, 1);
                $colIndex = 2;
                foreach ($this->period as $date) {
                    $colStart = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
                    $colEnd = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1);
                    $sheet->mergeCells("{$colStart}1:{$colEnd}1");
                    $sheet->setCellValue("{$colStart}1", strtoupper($date->translatedFormat('l, d F Y')));
                    $colIndex += 2;
                }

                $rekapStartCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
                $sheet->mergeCells("{$rekapStartCol}1:{$highestCol}1");
                $sheet->setCellValue("{$rekapStartCol}1", "RINGKASAN KEHADIRAN PEGAWAI");

                // Styling Global Header
                $sheet->getStyle("A1:{$highestCol}2")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1B4332']]
                ]);

                $sheet->mergeCells('A1:A2');
                $sheet->setCellValue('A1', 'NAMA PEGAWAI');

                // Borders
                $sheet->getStyle("A1:{$highestCol}{$highestRow}")->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
                ]);

                // Highlight Kolom Ringkasan
                $sheet->getStyle("{$rekapStartCol}3:{$highestCol}{$highestRow}")->getFill()
                    ->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F1F8E9');

                // Center Align untuk angka rekap
                $sheet->getStyle("{$rekapStartCol}3:{$highestCol}{$highestRow}")
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                foreach (range('A', $highestCol) as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
                $sheet->freezePane('B3');
            },
        ];
    }
}
