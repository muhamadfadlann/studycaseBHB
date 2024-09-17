<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shell</title>
    <style>
        body {
            background-image: url(https://images.axios.com/WYvWK9NI5RyzIE7pqWpwF0_1tTs=/0x341:5031x3171/1920x1080/2018/11/15/1542289790775.jpg?w=1920);
            text-align: center;
            margin: 0;
            padding: 0;
            font-family: Helvetica, Arial, sans-serif;
        }

        #container {
            width: 55%;
            margin: 50px auto;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 20px;
            border-radius: 25px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            color: #ffffff;
        }

        form {
            margin-bottom: 20px;
        }

        hr {
            width: 20%;
            border-style: dotted;
            border-width: 3px;
            margin: 20px auto;
        }

        @media screen and (max-width: 600px) {
            hr {
                width: 50%;
            }
        }
    </style>
</head>

<body>
    <div id="container">
        <h2>Form Pembelian Bahan Bakar Shell</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="jenis">Jenis Bahan Bakar:</label>
            <select id="jenis" name="jenis">
                <option value="Shell Super">Shell Super</option>
                <option value="Shell V-Power">Shell V-Power</option>
                <option value="Shell V-Power Diesel">Shell V-Power Diesel</option>
                <option value="Shell V-Power Nitro">Shell V-Power Nitro</option>
            </select>
            <br><br>
            <label for="jumlah">Jumlah Liter:</label>
            <input type="number" id="jumlah" name="jumlah" min="0" step="1" required>
            <br><br>
            <button type="submit">Beli</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            class Shell
            {
                protected $jenis;
                protected $harga;
                protected $jumlah;
                protected $ppn;

                public function __construct($jenis, $harga, $jumlah)
                {
                    $this->jenis = $jenis;
                    $this->harga = $harga;
                    $this->jumlah = $jumlah;
                    $this->ppn = 10; // PPN tetap 10%
                }

                public function getJenis()
                {
                    return $this->jenis;
                }

                public function getHarga()
                {
                    return $this->harga;
                }

                public function getJumlah()
                {
                    return $this->jumlah;
                }

                public function getPpn()
                {
                    return $this->ppn;
                }
            }

            class Beli extends Shell
            {
                public function hitungTotal()
                {
                    $total = $this->harga * $this->jumlah;
                    $total += $total * $this->ppn / 100;
                    return $total;
                }

                public function buktiTransaksi()
                {
                    $total = $this->hitungTotal();
                    echo "<div style='text-align: center;'>";
                    echo "<hr>"; // Garis putus-putus sebelum output
                    echo "<h3>Bukti Transaksi:</h3>";
                    echo "<p><strong>Anda membeli bahan bakar minyak dengan tipe :</strong> " . $this->jenis . "</p>";
                    echo "<p><strong>dengan jumlah :</strong> " . $this->jumlah . " Liter</p>"; // Menambahkan kata "Liter"
                    echo "<p><strong>Total yang harus anda bayar:</strong> Rp " . number_format($total, 2, ',', '.') . "</p>";
                    echo "<hr>"; // Garis putus-putus setelah output
                    echo "</div>";
                }

            }

            $hargaBahanBakar = [
                "Shell Super" => 13450.00,
                "Shell V-Power" => 14280.00,
                "Shell V-Power Diesel" => 14660.00,
                "Shell V-Power Nitro" => 14480.00,
            ];

            $jenis = $_POST["jenis"];
            $jumlah = $_POST["jumlah"];

            if (array_key_exists($jenis, $hargaBahanBakar)) {
                $harga = $hargaBahanBakar[$jenis];
                $beli = new Beli($jenis, $harga, $jumlah);
                $beli->buktiTransaksi();
            } else {
                echo "<p style='text-align: center;'>Jenis bahan bakar tidak valid.</p>";
            }
        }
        ?>

    </div>
</body>

</html>