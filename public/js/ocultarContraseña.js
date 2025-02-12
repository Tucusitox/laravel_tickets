// METODO PARA OCULTAR CONTRASEÑA DE INPUTS TIPO PASSWORD
function ocultarContraseña(inputId, iconId) {
  let claveEntrada = document.getElementById(inputId);
  let ocultarClave = document.getElementById(iconId);

  if (claveEntrada.type == "password") {
    claveEntrada.type = "text";
    ocultarClave.className = "bx bx-show fs-4";
  } else {
    claveEntrada.type = "password";
    ocultarClave.className = "bx bx-low-vision fs-4";
  }
}
