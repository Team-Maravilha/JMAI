const PDFDocument = require('pdfkit');

const header = (doc) => {
    doc.image('src/pdf/images/logo_rps.png', 10, 10, {width: 80});
    doc.image('src/pdf/images/logo_sns.png', 100, 10, {width: 80});
    //lOG currrent path
    doc.fontSize(13);
    doc.font('Helvetica-Bold');
    doc.text('Requerimento de Atestado Médico de Incapacidade', {align: 'center'}, 40);
    doc.font('Helvetica');
    doc.fontSize(10);
    doc.text('Lei n.º 14/2021 de 6 de abril e Decreto-Lei n.º 1/2022 de 3 de janeiro', {align: 'center'}, 55);
    //FULL ALIGN RIGHT
    doc.fontSize(10);
    doc.text('Data: 01/01/2024', 30, 10, {align: 'right', width: 560});
    doc.text('Nº:', 30, 25, {align: 'right', width: 480});
    doc.text(' REQ/00001/2024', 30, 25, {align: 'right', width: 560});

    //LINE 10px down
    doc.moveTo(10, 75).lineTo(600, 75).stroke();
}

const footer = (doc) => {
}


const buildPdf = (dataCallback, endCallback) => {   
    const doc = new PDFDocument();
    doc.on('data', dataCallback);
    doc.on('end', endCallback);

    //Cabeçalho
    header(doc);

    //Footer
    footer(doc);
    
    doc.end();
}

module.exports = {
    buildPdf
};