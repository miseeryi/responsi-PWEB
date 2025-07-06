<?php
class UnitConverter {
    
    public static function convertLength($value, $from, $to) {
        $toMeters = [
            'mm' => 0.001,
            'cm' => 0.01,
            'm' => 1,
            'km' => 1000,
            'in' => 0.0254,
            'ft' => 0.3048,
            'yd' => 0.9144,
            'mi' => 1609.34
        ];
        
        $meters = $value * $toMeters[$from];
        $result = $meters / $toMeters[$to];
        
        return round($result, 8);
    }
    
    public static function convertWeight($value, $from, $to) {
        $toGrams = [
            'mg' => 0.001,
            'g' => 1,
            'kg' => 1000,
            'ton' => 1000000,
            'oz' => 28.3495,
            'lb' => 453.592
        ];
        
        $grams = $value * $toGrams[$from];
        $result = $grams / $toGrams[$to];
        
        return round($result, 8);
    }
    
    public static function convertTemperature($value, $from, $to) {
        switch($from) {
            case 'c': $celsius = $value; break;
            case 'f': $celsius = ($value - 32) * 5/9; break;
            case 'k': $celsius = $value - 273.15; break;
            case 'r': $celsius = ($value - 491.67) * 5/9; break;
            default: $celsius = $value;
        }
        
        switch($to) {
            case 'c': return round($celsius, 4);
            case 'f': return round($celsius * 9/5 + 32, 4);
            case 'k': return round($celsius + 273.15, 4);
            case 'r': return round($celsius * 9/5 + 491.67, 4);
            default: return round($celsius, 4);
        }
    }
    
    public static function convertArea($value, $from, $to) {
        $toM2 = [
            'mm2' => 0.000001,
            'cm2' => 0.0001,
            'm2' => 1,
            'km2' => 1000000,
            'ha' => 10000
        ];
        
        $m2 = $value * $toM2[$from];
        $result = $m2 / $toM2[$to];
        
        return round($result, 8);
    }
    
    public static function convertVolume($value, $from, $to) {
        $toLiters = [
            'ml' => 0.001,
            'l' => 1,
            'm3' => 1000,
            'gal' => 3.78541,
            'qt' => 0.946353,
            'pt' => 0.473176
        ];
        
        $liters = $value * $toLiters[$from];
        $result = $liters / $toLiters[$to];
        
        return round($result, 8);
    }
    
    public static function getAllUnits() {
        return [
            'length' => [
                'mm' => 'Milimeter',
                'cm' => 'Sentimeter', 
                'm' => 'Meter',
                'km' => 'Kilometer',
                'in' => 'Inci',
                'ft' => 'Kaki',
                'yd' => 'Yard',
                'mi' => 'Mil'
            ],
            'weight' => [
                'mg' => 'Miligram',
                'g' => 'Gram',
                'kg' => 'Kilogram',
                'ton' => 'Ton',
                'oz' => 'Ons',
                'lb' => 'Pound'
            ],
            'temperature' => [
                'c' => 'Celsius',
                'f' => 'Fahrenheit',
                'k' => 'Kelvin',
                'r' => 'Rankine'
            ],
            'area' => [
                'mm2' => 'Milimeter Persegi',
                'cm2' => 'Sentimeter Persegi',
                'm2' => 'Meter Persegi',
                'km2' => 'Kilometer Persegi',
                'ha' => 'Hektar'
            ],
            'volume' => [
                'ml' => 'Mililiter',
                'l' => 'Liter',
                'm3' => 'Meter Kubik',
                'gal' => 'Galon',
                'qt' => 'Quart',
                'pt' => 'Pint'
            ]
        ];
    }
}

function validateInput($category, $value, $fromUnit, $toUnit) {
    $units = UnitConverter::getAllUnits();
    
    if (!isset($units[$category])) {
        return "Kategori tidak valid";
    }
    
    if (!is_numeric($value)) {
        return "Nilai harus berupa angka";
    }
    
    if (!isset($units[$category][$fromUnit])) {
        return "Satuan asal tidak valid";
    }
    
    if (!isset($units[$category][$toUnit])) {
        return "Satuan tujuan tidak valid";
    }
    
    return true;
}

function formatResult($value, $result, $fromUnit, $toUnit, $category) {
    $units = UnitConverter::getAllUnits();
    $fromName = $units[$category][$fromUnit];
    $toName = $units[$category][$toUnit];
    
    return [
        'input' => $value,
        'result' => $result,
        'from_unit' => $fromUnit,
        'to_unit' => $toUnit,
        'from_name' => $fromName,
        'to_name' => $toName,
        'category' => $category,
        'formatted' => "$value $fromName = $result $toName"
    ];
}
?>
