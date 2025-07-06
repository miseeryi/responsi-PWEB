<?php
function convertLength($value, $from, $to) {
    switch($from) {
        case 'mm': $meters = $value / 1000; break;
        case 'cm': $meters = $value / 100; break;
        case 'm': $meters = $value; break;
        case 'km': $meters = $value * 1000; break;
        default: $meters = $value;
    }
    
    switch($to) {
        case 'mm': return $meters * 1000;
        case 'cm': return $meters * 100;
        case 'm': return $meters;
        case 'km': return $meters / 1000;
        default: return $meters;
    }
}

function getUnitName($unit) {
    $names = [
        'mm' => 'Milimeter',
        'cm' => 'Sentimeter',
        'm' => 'Meter',
        'km' => 'Kilometer'
    ];
    return isset($names[$unit]) ? $names[$unit] : $unit;
}

$result = null;
$error = null;
$value = null;
$fromUnit = null;
$toUnit = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['value']) && isset($_POST['fromUnit']) && isset($_POST['toUnit'])) {
        $value = floatval($_POST['value']);
        $fromUnit = $_POST['fromUnit'];
        $toUnit = $_POST['toUnit'];
        
        if ($value < 0) {
            $error = "Nilai tidak boleh negatif";
        } elseif (empty($fromUnit) || empty($toUnit)) {
            $error = "Pilih satuan asal dan tujuan";
        } else {

            $result = convertLength($value, $fromUnit, $toUnit);
        }
    } else {
        $error = "Data form tidak lengkap";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Konversi Panjang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Hasil Konversi Panjang</h1>
        
        <div class="converter">
            <?php if ($error): ?>
                <div style="background: #ffebee; color: #c62828; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                    <strong>Error:</strong> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if ($result !== null && !$error): ?>
                <div id="result" class="show">
                    <strong>Hasil Konversi (PHP):</strong><br>
                    <?php echo $value; ?> <?php echo getUnitName($fromUnit); ?> = <?php echo $result; ?> <?php echo getUnitName($toUnit); ?>
                </div>
            <?php endif; ?>
            
            <div style="text-align: center; margin-top: 20px;">
                <a href="index.html" style="display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;">
                    ← Kembali ke Konverter
                </a>
            </div>
        </div>
    </div>
</body>
</html>
