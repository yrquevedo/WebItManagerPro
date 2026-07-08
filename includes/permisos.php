<?php

function esAdministrador(){
    return isset($_SESSION["rol"]) && $_SESSION["rol"] == "Administrador";
}

function esVendedor(){
    return isset($_SESSION["rol"]) && $_SESSION["rol"] == "Vendedor";
}

function esInvitado(){
    return isset($_SESSION["rol"]) && $_SESSION["rol"] == "Invitado";
}

function puedeEditar(){
    return esAdministrador() || esVendedor();
}

function puedeEliminar(){
    return esAdministrador();
}

function puedeRegistrar(){
    return esAdministrador();
}

//funcion para GestionarUsuarios
function puedeGestionarUsuarios(){
    return isset($_SESSION["rol"]) && $_SESSION["rol"] == "Administrador";
}
?>