function showProductImage(event) {
    let imgPreview = document.getElementById('ff');
    imgPreview.src = URL.createObjectURL(event.files[0]);
}