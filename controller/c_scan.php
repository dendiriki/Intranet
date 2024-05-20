<?php

// Uncomment the following line if you don't have 'vendor/autoload.php' in your project.
// require 'path/to/composer/vendor/autoload.php';

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

if ($action == "scan") {

    if (isset($_GET["search"])) {
      
        
$dataToRetrieve = [
    'FM',
    'KD_JENIS_TRANSAKSI',
    'FG_PENGGANTI',
    'NOMOR_FAKTUR',
    'MASA_PAJAK',
    'TAHUN_PAJAK',
    'TANGGAL_FAKTUR',
    'NPWP',
    'NAMA',
    'ALAMAT_LENGKAP',
    'JUMLAH_DPP',
    'JUMLAH_PPN',
    'JUMLAH_PPNBM',
    'IS_CREDITABLE'
];

session_start();

// Fungsi untuk menyimpan data ke dalam file data.txt
function saveDataToFile($data)
{
    $dataString = json_encode($data) . PHP_EOL;
    file_put_contents("data.txt", $dataString, FILE_APPEND);
}

// Fungsi untuk membaca data dari file data.txt
function readDataFromFile()
{
    $data = [];
    if (file_exists("data.txt")) {
        $fileLines = file("data.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($fileLines as $line) {
            $data[] = json_decode($line, true);
        }
    }
    return $data;
}

$dataFromFile = readDataFromFile();

// Cek apakah ada data dalam tabel
$disableCombo = !empty($dataFromFile);

// Cek apakah ada permintaan POST untuk URL XML
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["clear_data"])) {
        // Jika tombol "Clear Data" ditekan, hapus semua data dari file data.txt
        file_put_contents("data.txt", "");
        // Hapus juga data dari sesi
        unset($_SESSION['allData']);
        $disableCombo = false; // Aktifkan kembali combo box setelah data dihapus
    } elseif (isset($_POST["save_excel"])) {
        // Jika tombol "Save as Excel" ditekan, buat file Excel dan kirim sebagai tautan unduhan
        if (!empty($dataFromFile)) {
            $spreadsheet = new Spreadsheet();
            $worksheet = $spreadsheet->getActiveSheet();

            // Buat header sesuai dengan dataToRetrieve
            $col = 'A';
            $dataToRetrieve = array_keys($dataFromFile[0]);
            foreach ($dataToRetrieve as $data) {
                $worksheet->setCellValue($col . '1', $data);
                $col++;
            }

            // Isi data dari data.txt
            $row = 2;
            foreach ($dataFromFile as $dataSet) {
                $col = 'A';
                foreach ($dataToRetrieve as $data) {
                    $worksheet->setCellValue($col . $row, $dataSet[$data]);
                    $col++;
                }
                $row++;
            }

            // Buat file Excel
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="data.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        } else {
            echo '<script>alert("Tidak ada data untuk disimpan dalam file Excel.");</script>';
        }
    } else {
        // Validasi inputan URL XML
        if (isset($_POST["xml_url"])) {
            $xml_url = $_POST["xml_url"];
            if (!empty($xml_url)) {
                $xml_data = file_get_contents($xml_url);
                if ($xml_data) {
                    $xml = new SimpleXMLElement($xml_data);
                    $nomorFakturBaru = (string)$xml->{'nomorFaktur'};
                    $dataExists = false;

                    $selectedCompany = $_POST["jenis_transaksi"]; // Ambil nilai dari combo box

                    if (isset($_SESSION['allData'])) {
                        foreach ($_SESSION['allData'] as $dataSet) {
                            $nomorFakturLama = $dataSet['NOMOR_FAKTUR'];
                            if ($nomorFakturBaru === $nomorFakturLama) {
                                $dataExists = true;
                                break;
                            }
                        }
                    }

                    $lawantransaksispace = $xml->{'namaLawanTransaksi'};
                    $lawantransaksi = preg_replace("/[^a-zA-Z0-9]+/", "", $lawantransaksispace);

                    // Periksa apakah namaLawanTransaksi sama dengan nilai combo box
                    if ((string)$lawantransaksi !== $selectedCompany) {
                        $dataExists = true;
                        echo '<script>alert("Input URL bukan company yang valid.");</script>';
                    }

                    if (!$dataExists) {
                        // Pecah string tanggal untuk mendapatkan tahun dan bulan
                        $tanggalFaktur = (string)$xml->{'tanggalFaktur'};
                        list($tanggal, $bulan, $tahun) = explode('/', $tanggalFaktur);

                        // Simpan data ke dalam file dan sesi
                        $dataArray = [
                            'FM' => 'FM',
                            'KD_JENIS_TRANSAKSI' => (string)$xml->{'kdJenisTransaksi'},
                            'FG_PENGGANTI' => (string)$xml->{'fgPengganti'},
                            'NOMOR_FAKTUR' => (string)$xml->{'nomorFaktur'},
                            'MASA_PAJAK' => $bulan,
                            'TAHUN_PAJAK' => $tahun,
                            'TANGGAL_FAKTUR' => $tanggalFaktur,
                            'NPWP' => (string)$xml->{'npwpPenjual'}, 
                            'NAMA' => (string)$xml->{'namaPenjual'},
                            'ALAMAT_LENGKAP' => (string)$xml->{'alamatPenjual'},
                            'JUMLAH_DPP' => (string)$xml->{'jumlahDpp'},
                            'JUMLAH_PPN' => (string)$xml->{'jumlahPpn'},
                            'JUMLAH_PPNBM' => (string)$xml->{'jumlahPpnBm'},
                            'IS_CREDITABLE' => '1'
                        ];

                        if (isset($_SESSION['allData'])) {
                            $_SESSION['allData'][] = $dataArray;
                        } else {
                            $_SESSION['allData'] = [$dataArray];
                        }

                        saveDataToFile($dataArray);
                    } else {
                        echo '<script>alert("Data dengan nomor faktur pajak ' . $nomorFakturBaru . ' sudah ada dalam daftar.");</script>';
                    }
                } else {
                    echo 'Gagal mengambil data XML dari URL yang diberikan.';
                }
            }
        }
    }
}

$dataFromFile = readDataFromFile();

    }
    require(TEMPLATE_PATH . "/scan.php");
}


?>
