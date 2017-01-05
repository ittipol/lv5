class Token {

	constructor() {}

	generateToken() {
		let codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	  codeAlphabet += "abcdefghijklmnopqrstuvwxyz";
	  codeAlphabet += "0123456789";

	  let code = '';
	  let len = codeAlphabet.length;

	  for (let i = 0; i <= 7; i++) {
	  	code += codeAlphabet[Math.floor(Math.random() * (len - 0) + 0)];
	  };

		return code;
	}

}