// PARA INDICAR COMO SE DEBE ESCRIBIR EL CODIGO 
// EN INPUTS DONDE VAYA UN CODIGO MAYUSCULA DE 8 CARACTERES
// PARA EL CODIGO DE RECUPERACION DE CONTRASEÑA
const input1 = document.getElementById('inputCodigo');
input1.addEventListener('input', function() {
    this.value = this.value.toUpperCase();
    if (this.value.length >= 8) {
        this.value = this.value.substring(0, 8);
    }
});