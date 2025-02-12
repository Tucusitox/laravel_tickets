// ESTE ES PARA EL CODIGO DE TICKETS DE 6 CARACTERES
const input2 = document.getElementById("inputTicketCodigo");
input2.addEventListener("input", function () {
    this.value = this.value.toUpperCase();
    if (this.value.length >= 6) {
        this.value = this.value.substring(0, 6);
    }
});
