const units = {
  length: {
    mm: "Milimeter",
    cm: "Sentimeter",
    m: "Meter",
    km: "Kilometer",
    in: "Inci",
    ft: "Kaki",
    yd: "Yard",
    mi: "Mil",
  },
  weight: {
    mg: "Miligram",
    g: "Gram",
    kg: "Kilogram",
    ton: "Ton",
    oz: "Ons",
    lb: "Pound",
  },
  temperature: {
    c: "Celsius",
    f: "Fahrenheit",
    k: "Kelvin",
    r: "Rankine",
  },
  area: {
    mm2: "Milimeter Persegi",
    cm2: "Sentimeter Persegi",
    m2: "Meter Persegi",
    km2: "Kilometer Persegi",
    ha: "Hektar",
  },
  volume: {
    ml: "Mililiter",
    l: "Liter",
    m3: "Meter Kubik",
    gal: "Galon",
    qt: "Quart",
    pt: "Pint",
  },
}

function updateUnits() {
  const category = document.getElementById("category").value
  const fromUnit = document.getElementById("fromUnit")
  const toUnit = document.getElementById("toUnit")

  fromUnit.innerHTML = '<option value="">Pilih satuan asal</option>'
  toUnit.innerHTML = '<option value="">Pilih satuan tujuan</option>'

  if (category && units[category]) {
    Object.keys(units[category]).forEach((unit) => {
      const option1 = new Option(units[category][unit], unit)
      const option2 = new Option(units[category][unit], unit)
      fromUnit.add(option1)
      toUnit.add(option2)
    })
  }

  document.getElementById("result").classList.remove("show")
}

function convertClient() {
  const category = document.getElementById("category").value
  const value = Number.parseFloat(document.getElementById("value").value)
  const fromUnit = document.getElementById("fromUnit").value
  const toUnit = document.getElementById("toUnit").value

  if (!category || !value || !fromUnit || !toUnit) {
    alert("Mohon lengkapi semua field!")
    return
  }

  let result

  try {
    switch (category) {
      case "length":
        result = convertLength(value, fromUnit, toUnit)
        break
      case "weight":
        result = convertWeight(value, fromUnit, toUnit)
        break
      case "temperature":
        result = convertTemperature(value, fromUnit, toUnit)
        break
      case "area":
        result = convertArea(value, fromUnit, toUnit)
        break
      case "volume":
        result = convertVolume(value, fromUnit, toUnit)
        break
      default:
        throw new Error("Kategori tidak valid")
    }

    showResult(`${value} ${units[category][fromUnit]} = ${result} ${units[category][toUnit]}`, "Client-side JavaScript")
  } catch (error) {
    alert("Error: " + error.message)
  }
}

function convertLength(value, from, to) {
  const meters = {
    mm: value / 1000,
    cm: value / 100,
    m: value,
    km: value * 1000,
    in: value * 0.0254,
    ft: value * 0.3048,
    yd: value * 0.9144,
    mi: value * 1609.34,
  }

  const meterValue = meters[from]

  const result = {
    mm: meterValue * 1000,
    cm: meterValue * 100,
    m: meterValue,
    km: meterValue / 1000,
    in: meterValue / 0.0254,
    ft: meterValue / 0.3048,
    yd: meterValue / 0.9144,
    mi: meterValue / 1609.34,
  }

  return result[to].toFixed(6)
}

function convertWeight(value, from, to) {
  const grams = {
    mg: value / 1000,
    g: value,
    kg: value * 1000,
    ton: value * 1000000,
    oz: value * 28.3495,
    lb: value * 453.592,
  }

  const gramValue = grams[from]

  const result = {
    mg: gramValue * 1000,
    g: gramValue,
    kg: gramValue / 1000,
    ton: gramValue / 1000000,
    oz: gramValue / 28.3495,
    lb: gramValue / 453.592,
  }

  return result[to].toFixed(6)
}

function convertTemperature(value, from, to) {
  let celsius

  switch (from) {
    case "c":
      celsius = value
      break
    case "f":
      celsius = ((value - 32) * 5) / 9
      break
    case "k":
      celsius = value - 273.15
      break
    case "r":
      celsius = ((value - 491.67) * 5) / 9
      break
  }

  switch (to) {
    case "c":
      return celsius.toFixed(2)
    case "f":
      return ((celsius * 9) / 5 + 32).toFixed(2)
    case "k":
      return (celsius + 273.15).toFixed(2)
    case "r":
      return ((celsius * 9) / 5 + 491.67).toFixed(2)
  }
}

function convertArea(value, from, to) {
  const m2 = {
    mm2: value / 1000000,
    cm2: value / 10000,
    m2: value,
    km2: value * 1000000,
    ha: value * 10000,
  }

  const m2Value = m2[from]

  const result = {
    mm2: m2Value * 1000000,
    cm2: m2Value * 10000,
    m2: m2Value,
    km2: m2Value / 1000000,
    ha: m2Value / 10000,
  }

  return result[to].toFixed(6)
}

function convertVolume(value, from, to) {
  const liters = {
    ml: value / 1000,
    l: value,
    m3: value * 1000,
    gal: value * 3.78541,
    qt: value * 0.946353,
    pt: value * 0.473176,
  }

  const literValue = liters[from]

  const result = {
    ml: literValue * 1000,
    l: literValue,
    m3: literValue / 1000,
    gal: literValue / 3.78541,
    qt: literValue / 0.946353,
    pt: literValue / 0.473176,
  }

  return result[to].toFixed(6)
}

function showResult(resultText, method) {
  const resultDiv = document.getElementById("result")
  resultDiv.innerHTML = `
        <h3>Hasil Konversi (${method}):</h3>
        <p>${resultText}</p>
    `
  resultDiv.classList.add("show")
}

function convertJS() {
  const value = Number.parseFloat(document.getElementById("value").value)
  const fromUnit = document.getElementById("fromUnit").value
  const toUnit = document.getElementById("toUnit").value

  if (!value) {
    alert("Masukkan nilai yang valid!")
    return
  }

  let meters
  switch (fromUnit) {
    case "mm":
      meters = value / 1000
      break
    case "cm":
      meters = value / 100
      break
    case "m":
      meters = value
      break
    case "km":
      meters = value * 1000
      break
  }

  let result
  switch (toUnit) {
    case "mm":
      result = meters * 1000
      break
    case "cm":
      result = meters * 100
      break
    case "m":
      result = meters
      break
    case "km":
      result = meters / 1000
      break
  }

  const resultDiv = document.getElementById("result")
  const fromName = getUnitName(fromUnit)
  const toName = getUnitName(toUnit)

  resultDiv.innerHTML = `
      <strong>Hasil Konversi (JavaScript):</strong><br>
      ${value} ${fromName} = ${result} ${toName}
  `
  resultDiv.classList.add("show")
}

function getUnitName(unit) {
  const names = {
    mm: "Milimeter",
    cm: "Sentimeter",
    m: "Meter",
    km: "Kilometer",
  }
  return names[unit]
}
