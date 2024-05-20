<?php
// index.php

$pageTitle = 'Data Faktur Pajak PT. ISPAT INDO';
$selectedCompanyValue = 'PTISPATINDO'; // Nilai default, bisa disesuaikan dengan default yang diinginkan

if (isset($_POST['jenis_transaksi'])) {
    $selectedCompany = $_POST['jenis_transaksi'];
    $selectedCompanyValue = $selectedCompany;
    switch ($selectedCompany) {
        case 'PTISPATINDO':
            $pageTitle = 'Data Faktur Pajak PT. ISPAT INDO';
            break;
        case 'PTISPATBUKITBAJA':
            $pageTitle = 'Data Faktur Pajak PT. ISPAT BUKIT BAJA';
            break;
        case 'PTISPATWIREPRODUCTS':
            $pageTitle = 'Data Faktur Pajak PT. ISPAT WIRE PRODUCTS';
            break;
        case 'PTISPATPANCAPUTERA':
            $pageTitle = 'Data Faktur Pajak PT. ISPAT PANCA PUTERA';
            break;
        // Tambahkan case untuk perusahaan lain jika diperlukan
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Faktur Pajak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 1px solid black; /* tambahkan baris ini */
        }

        th, td {
            border: 1px solid black; /* tambahkan baris ini */
            padding: 12px;
            text-align: left;
        }


        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            font-weight: bold;
        }

        input[type="text"] {
            width: 300px;
            padding: 8px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            padding: 10px;
            background-color: #337ab7;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #286090;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #337ab7;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .alert {
            margin-top: 10px;
            padding: 10px;
            background-color: #f2dede;
            color: #a94442;
            border: 1px solid #ebccd1;
            border-radius: 4px;
        }

        .btn-group {
            margin-top: 10px;
        }

        .btn {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <?php include 'common/header.php' ?>
    <?php include 'common/navigation.php' ?>

    
    <h1><?php echo $pageTitle; ?></h1>

    <form method="POST" action="?action=scan&search" id="myForm">
        <label for="xml_url">Masukkan URL XML:</label>
        <input type="text" name="xml_url" id="xml_url" autofocus>
        <input type="submit" value="Ambil Data" class="btn btn-primary">
        <input type="submit" name="clear_data" value="Clear Data" class="btn btn-danger">
        <input type="submit" name="save_excel" value="Save as Excel" class="btn btn-success">
        <select name="jenis_transaksi" style="display: none;">
            <option value="PTISPATINDO" <?php echo ($selectedCompanyValue === 'PTISPATINDO') ? 'selected' : ''; ?>>PT. ISPAT INDO</option>
            <option value="PTISPATBUKITBAJA" <?php echo ($selectedCompanyValue === 'PTISPATBUKITBAJA') ? 'selected' : ''; ?>>PT. ISPAT BUKIT BAJA</option>
            <option value="PTISPATWIREPRODUCTS" <?php echo ($selectedCompanyValue === 'PTISPATWIREPRODUCTS') ? 'selected' : ''; ?>>PT. ISPAT WIRE PRODUCTS</option>
            <option value="PTISPATPANCAPUTERA" <?php echo ($selectedCompanyValue === 'PTISPATPANCAPUTERA') ? 'selected' : ''; ?>>PT. ISPAT PANCA PUTERA</option>
            <!-- Tambahkan opsi untuk perusahaan lain jika diperlukan -->
        </select>
    </form>

    <div class="btn-group">
        <!-- Tombol Ispat Indo -->
        <button type="submit" class="btn btn-info" form="myForm" name="jenis_transaksi" value="PTISPATINDO" <?php if (!empty($dataFromFile)) echo 'style="display: none;"'; ?>>PT. ISPAT INDO</button>
        <!-- Tombol Ispat Bukit Baja -->
        <button type="submit" class="btn btn-info" form="myForm" name="jenis_transaksi" value="PTISPATBUKITBAJA" <?php if (!empty($dataFromFile)) echo 'style="display: none;"'; ?>>PT. ISPAT BUKIT BAJA</button>
        <!-- Tombol Ispat Wire Produk -->
        <button type="submit" class="btn btn-info" form="myForm" name="jenis_transaksi" value="PTISPATWIREPRODUCTS" <?php if (!empty($dataFromFile)) echo 'style="display: none;"'; ?>>PT. ISPAT WIRE PRODUCTS</button>
        <button type="submit" class="btn btn-info" form="myForm" name="jenis_transaksi" value="PTISPATPANCAPUTERA" <?php if (!empty($dataFromFile)) echo 'style="display: none;"'; ?>>PT. ISPAT PANCA PUTERA</button>
    </div>

    <?php
    if (!empty($dataFromFile)) {
        echo '<h2>Data Faktur Pajak:</h2>';
        echo '<table id="dataTable">';
        echo '<tr>';
        foreach ($dataToRetrieve as $data) {
            echo '<th>' . $data . '</th>';
        }

        foreach ($dataFromFile as $dataSet) {
            echo '<tr>';
            foreach ($dataToRetrieve as $data) {
                echo '<td>' . $dataSet[$data] . '</td>';
            }
        }
        echo '</table>';
    }

    if (isset($_POST["save_excel"])) {
        if (empty($dataFromFile)) {
            echo '<div class="alert alert-danger">Tidak ada data untuk disimpan dalam file Excel.</div>';
        }
    }
    ?>

    <?php include 'common/footer.php' ?>
</body>
</html>
