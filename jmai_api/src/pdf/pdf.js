const fs = require("fs");
const pdf = require("html-pdf");

const buildPdf = (res) => {
	let html = `
    <html>
    <head>
        <title>Teste PDF</title>
    </head>
    <body>
        <div class="header">

            <div class="logo">
                <img src="{{image}}" alt="Logo RPS" width="100" height="100">

            </div>
    </body>
    </html>`;

    var path = require('path');
    var image = path.join('file://', __dirname, 'images', 'logo_rps.png');
    console.log(image);
    html = html.replace('{{image}}', image)

	// Opções para a geração do PDF
	const options = { 
        format: "A4",
        orientation: "portrait",
        border: "10mm",
    };


	pdf.create(html, options).toBuffer((err, buffer) => {
        if (err) {
            res.status(500).send('Erro ao gerar o PDF');
            return;
        }

        res.type('application/pdf');
        res.send(buffer);

    });
};

module.exports = {
	buildPdf,
};
