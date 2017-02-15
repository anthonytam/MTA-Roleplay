vehicleName = { 
	[445] = "Mercedes Benz 300D",
	[602] = "Dodge Stealth",
	[518] = "Chevy Monte Carlo",
	[429] = "Dodge Viper RT",
	[401] = "Mercury Cougar",
	[536] = "Chevy Caprice",
	[496] = "Honda CRX",
	[422] = "Ford Ranger",
	[575] = "Cadillac",
	[402] = "Camaro Iroc",
	[541] = "Ford GT40",
	[438] = "Checker Cab",
	[527] = "Chevy Cavalier",
	[415] = "Ferrari Tessarosta",
	[542] = "Buick Skylark",
	[589] = "Volkswagen Golf GTI",
	[480] = "Porsche 911",
	[507] = "Buick Roadmaster",
	[562] = "Nissan Skyline",
	[585] = "Infinity J30",
	[419] = "Cadillac Eldorado",
	[587] = "Nissan 300x",
	[533] = "Mercedes SL",
	[565] = "Honda Civic",
	[526] = "Ford Thunderbird",
	[466] = "Chevy Del Ray",
	[492] = "Chrysler 5th Avenue",
	[474] = "", --Name:Hermes
	[579] = "Land Rover Range Rover",
	[545] = "Ford Coupe",
	[411] = "Acura NSX",
	[546] = "Chevy Lumina",
	[559] = "Toyota Supra",
	[400] = "Jeep Cheorokee",
	[517] = "Buick Regal",
	[410] = "Dodge Aires Coupe",
	[551] = "Ford Crown Victoria",
	[500] = "Jeep Wrangler",
	[418] = "Chevy Astrovan",
	[516] = "Buick Century",
	[467] = "Chevy Bel Air",
	[404] = "Chevy Nova Wagon",
	[603] = "Pontiac Trans Am",
	[600] = "Chevy El Camino",
	[426] = "Chevy Caprice Classic",
	[436] = "Honda Prelude",
	[547] = "Oldsmobile Cutlass Cierra",
	[490] = "Ford Branco",
	[479] = "Ford LTD",
	[534] = "Cadillac Brougham",
	[442] = "Cadillac Victorian Hearse",
	[475] = "Chevy Chevelle",
	[543] = "Ford 150",
	[567] = "Chevy Impala",
	[405] = "BMW 525i",
	[535] = "Chevy 1500",
	[458] = "Ford Taurus",
	[580] = "Rolls Royce Shadow",
	[439] = "Oldsmobile Cutlass",
	[561] = "Honda Accord",
	[409] = "Lincoln Town Car",
	[560] = "Subaru Impreza",
	[550] = "Honda Accord",
	[506] = "Mitsubishi 3000GT",
	[549] = "Chevy Corvair",
	[420] = "Chevy Caprice Classic",
	[566] = "Monte Carlo",
	[576] = "Chevy Impala",
	[451] = "Ferrari F40",
	[558] = "Mitsubishi Eclipse",
	[540] = "BMW 325i",
	[491] = "Ford Thunderbird",
	[412] = "Chevy Impala",
	[478] = "Chevy Pickup",
	[421] = "Lincoln Mark V",
	[529] = "Dodge Dynasty",
	[554] = "Chevy 1500",
	[477] = "Mazda Rx7"
}

function getVehicleRealName(theVehicle)
	return vehicleName[getVehicleModelFromName(getVehicleName(theVehicle))] or "lol fuck no name"
end