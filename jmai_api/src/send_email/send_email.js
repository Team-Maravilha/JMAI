const nodemailer = require("nodemailer");

const SendEmail = (to, subject, text, html) => {
	/* Configuração do Nodemailer */
	let config = {
		service: "gmail",
		auth: {
			user: process.env.EMAIL_SENDER,
			pass: process.env.EMAIL_PASSWORD,
		},
	};

	let transporter = nodemailer.createTransport(config);

	let mailOptions = {
		from: process.env.EMAIL_SENDER,
		to: to,
		subject: subject,
		text: text,
		html: html,
	};

	transporter.sendMail(mailOptions, (error, info) => {
		if (error) {
            console.log(error);
			return [false, error.message];
		} else {
            //console.log(info);
			return [true, info.messageId];
		}
	});
};

module.exports = SendEmail;
