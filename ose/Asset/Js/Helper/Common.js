function FechaFormatoBD(fecha) {
	var y = fecha.getFullYear();
	var m = fecha.getMonth() + 1;
	var d = fecha.getDate();
	var mm = m < 10 ? '0' + m : m;
	var dd = d < 10 ? '0' + d : d;
	return '' + y + '-' + mm + '-' + dd;
}
function VerifyFunctions(list){
	let functions=list.split(',');
	functions.forEach(element => {console.log(element);
		$("button[name='verify"+element+"']").show();
	});
}

const service = {
	path: '/OSE-skynet/ose',
	apiPath: '/OSE-skynet/ose',
};

const GenerateUniqueId = () => {
	let length = 6;
	let timestamp = +new Date;

	let _getRandomInt = function( min, max ) {
		return Math.floor( Math.random() * ( max - min + 1 ) ) + min;
	};

	let ts = timestamp.toString();
	let parts = ts.split( "" ).reverse();
	let id = "";
	for( let i = 0; i < length; ++i ) {
		let index = _getRandomInt( 0, parts.length - 1 );
		id += parts[index];
	}
	return id;
};

const RoundCurrency = (num, decimals = 2) => {
	let number = parseFloat(num);
	number = Math.round(number * Math.pow(10, decimals)) / Math.pow(10, decimals);
	return  number.toFixed(decimals);
};

const ValidateInputIsNumber = (input) => {
	let regex = /[^0-9.,]/g;
	input.value = input.value.replace(regex, '');
	return regex.test(input.value);
};

const ValidateRUC = ruc => {
	if (isNaN(ruc)){
		return false;
	}

	if (!(ruc >= 1e10 && ruc < 11e9
		|| ruc >= 15e9 && ruc < 18e9
		|| ruc >= 2e10 && ruc < 21e9))
		return false;

	let sum;
	let i = 0;
	for (sum = -(ruc%10<2); i<11; i++, ruc = ruc/10|0){
		sum += (ruc % 10) * (i % 7 + (i/7|0) + 1);
	}

	return sum % 11 === 0
};

const ValidateDNI = dni => {
	return /^[0-9]{8}$/.test(dni);
};

const ValidateEmail = email => {
	return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email);
};
