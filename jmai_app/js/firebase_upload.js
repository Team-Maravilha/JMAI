const firebaseConfig = {
  apiKey: "AIzaSyD-LdegQp29aR1CX4OgbF_A5dI3XUEzSaA",
  authDomain: "jmai-docs.firebaseapp.com",
  projectId: "jmai-docs",
  storageBucket: "jmai-docs.appspot.com",
  messagingSenderId: "800267019036",
  appId: "1:800267019036:web:4908dc0140376359a6d0d9",
};
const app = firebase.initializeApp(firebaseConfig);
const storage = app.storage();

function generateUniqueName(originalName) {
  const date = new Date();
  const timestamp = date.getTime();
  const randomNum = Math.floor(Math.random() * 1000);
  return timestamp + "_" + randomNum + "_" + originalName;
}

let documentos = [];

function uploadFileToFirebase(file) {
  const uniqueName = generateUniqueName(file.name);
  const storageRef = storage.ref("docs/" + uniqueName);

  storageRef
    .put(file)
    .then((snapshot) => {
      snapshot.ref.getDownloadURL().then((url) => {
        toastr.success("Documento carregado com Sucesso!", "Sucesso");

        documentos.push({ nome_documento: file.name, nome_documento_unico: uniqueName, caminho_documento: url });
      });
    })
    .catch((error) => {
      toastr.error("Ocorreu um erro ao adicionar o Documento.", "Erro");
    });
}

function removeFileFromFirebase(fileName) {
  const documento = documentos.find((doc) => doc.nome_documento == fileName);
  const fileRef = storage.ref("docs/" + documento.nome_documento_unico);

  fileRef
    .delete()
    .then(() => {
      toastr.success("Documento removido com Sucesso!", "Sucesso");
      documentos.splice(
        documentos.findIndex((doc) => doc.nome_documento == fileName),
        1
      );
    })
    .catch((error) => {
      toastr.error("Ocorreu um erro ao remover o Documento.", "Erro");
    });
}

// // Função para enviar arquivos para o Firebase
// function uploadFileToFirebase(file) {
//   const storageRef = storage.ref("docs/" + file.name);
//   storageRef.put(file).then((snapshot) => {
//     console.log("Uploaded a blob or file!");
//     snapshot.ref.getDownloadURL().then((url) => {
//       console.log(url);
//     });
//   });
// }

// // Função para remover arquivos do Firebase
// function removeFileFromFirebase(fileName) {
//   const fileRef = storage.ref('docs/' + fileName);

//   fileRef.delete().then(() => {
//       console.log('File successfully deleted!');
//   }).catch((error) => {
//       console.error('Error removing file: ', error);
//   });
// }
