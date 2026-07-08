/* ============================================================
   VALIDAR FORMULARIO DE REGISTRO
   Esta función se ejecuta cuando registras un producto nuevo.
   Comprueba que:
   - El precio tenga formato decimal correcto.
   - El precio no sea negativo.
   - La cantidad sea mayor que 0.
============================================================ */

function validarRegistro(){

    // Capturamos el campo precio del formulario
    let precio = document.getElementById("precio");

    // Capturamos el campo cantidad del formulario
    let cantidad = document.getElementById("cantidad");

    // Capturamos el párrafo donde mostraremos los errores
    let mensaje = document.getElementById("mensajeError");

    // Limpiamos cualquier mensaje anterior
    mensaje.innerHTML = "";

    // Expresión regular para permitir números enteros o decimales con máximo 2 decimales
    // Ejemplos válidos: 899, 899.99, 25.5
    let decimal = /^[0-9]+(\.[0-9]{1,2})?$/;

    // Si el precio no cumple el formato decimal, se muestra error
    if(!decimal.test(precio.value)){
        mensaje.innerHTML = "El precio debe ser decimal. Ejemplo: 899.99";
        return false;
    }

    // Convertimos el precio a número decimal y comprobamos que no sea negativo
    if(parseFloat(precio.value) < 0){
        mensaje.innerHTML = "El precio no puede ser negativo.";
        return false;
    }

    // Convertimos la cantidad a número entero y comprobamos que sea mayor que 0
    if(parseInt(cantidad.value) <= 0){
        mensaje.innerHTML = "La cantidad no puede ser 0.";
        return false;
    }

    // Si todo está correcto, permite enviar el formulario
    return true;
}


/* ============================================================
   VALIDAR PRECIO EN ACTUALIZACIÓN
   Esta función se usa cuando editas un producto.
   Permite que el precio esté vacío porque puedes actualizar
   solo el stock.
============================================================ */

function validarPrecio(){

    let precio = document.getElementById("precio");
    let mensaje = document.getElementById("mensajeError");

    mensaje.innerHTML = "";

    let decimal = /^[0-9]+(\.[0-9]{1,2})?$/;

    // Solo valida el precio si el usuario ha escrito algo
    if(precio.value !== "" && !decimal.test(precio.value)){
        mensaje.innerHTML = "El precio debe ser decimal. Ejemplo: 999.99";
        return false;
    }

    // Si escribió precio, no puede ser negativo
    if(precio.value !== "" && parseFloat(precio.value) < 0){
        mensaje.innerHTML = "El precio no puede ser negativo.";
        return false;
    }

    return true;
}


/* ============================================================
   RELLENAR DATOS AUTOMÁTICAMENTE
   Esta función se ejecuta cuando seleccionas un producto
   en el desplegable del formulario de registro.

   Según el producto elegido, rellena automáticamente:
   - Descripción
   - Categoría
   - Marca
   - Imagen
   - Vista previa de imagen
============================================================ */

function rellenarProducto(){

    // Obtenemos el producto seleccionado en el desplegable
    let producto = document.getElementById("producto").value;

    // Capturamos los campos del formulario que se rellenarán solos
    let descripcion = document.getElementById("descripcion");
    let categoria = document.getElementById("categoria");
    let marca = document.getElementById("marca");
    let imagen = document.getElementById("imagen");

    // Capturamos la imagen de vista previa
    let preview = document.getElementById("previewImagen");

    // Capturamos el texto que aparece debajo de la imagen
    let nombreImagen = document.getElementById("nombreProductoImagen");


    /* 
       Objeto con todos los productos disponibles.
       Cada producto tiene:
       - descripcion
       - categoria
       - marca
       - imagen

       IMPORTANTE:
       El nombre de la imagen debe coincidir exactamente
       con el archivo guardado dentro de la carpeta img.
    */

    let datos = {

        "Portátil Lenovo IdeaPad": {
            descripcion: "Intel i7, 16GB RAM y SSD 512GB",
            categoria: "Portátiles",
            marca: "Lenovo",
            imagen: "lenovo.jpg"
        },

        "MacBook Air M4": {
            descripcion: "Chip Apple Silicon M4, 16GB RAM y SSD 512GB",
            categoria: "Portátiles",
            marca: "Apple",
            imagen: "macbook.jpg"
        },

        "Dell XPS 13": {
            descripcion: "Intel Core Ultra 7, 16GB RAM y SSD 1TB",
            categoria: "Portátiles",
            marca: "Dell",
            imagen: "dellxps.jpg"
        },

        "ASUS ZenBook 14": {
            descripcion: "AMD Ryzen 7, 16GB RAM y SSD 512GB",
            categoria: "Portátiles",
            marca: "ASUS",
            imagen: "asuszenbook.jpg"
        },

        "RTX 5070": {
            descripcion: "Tarjeta gráfica NVIDIA de 12GB",
            categoria: "Componentes",
            marca: "NVIDIA",
            imagen: "tarjetagraficaRTX.jpg"
        },

        "NVIDIA RTX 5080": {
            descripcion: "Tarjeta gráfica NVIDIA de 16GB GDDR7",
            categoria: "Componentes",
            marca: "NVIDIA",
            imagen: "rtx5080.jpg"
        },

        "AMD Ryzen 7 9800X3D": {
            descripcion: "Procesador gaming de alto rendimiento",
            categoria: "Componentes",
            marca: "AMD",
            imagen: "ryzen7.jpg"
        },

        "Corsair Vengeance 32GB": {
            descripcion: "Memoria RAM DDR5 32GB",
            categoria: "Componentes",
            marca: "Corsair",
            imagen: "ramcorsair.jpg"
        },

        "SSD Samsung 1TB": {
            descripcion: "Disco SSD NVMe de 1TB",
            categoria: "Almacenamiento",
            marca: "Samsung",
            imagen: "ssdSamsung1TB.jpg"
        },

        "SSD Crucial BX500": {
            descripcion: "SSD SATA 2.5 pulgadas de 500GB",
            categoria: "Almacenamiento",
            marca: "Crucial",
            imagen: "crucial.jpg"
        },

        "Disco Externo WD 2TB": {
            descripcion: "Disco duro externo portátil USB 3.0",
            categoria: "Almacenamiento",
            marca: "Western Digital",
            imagen: "wd.jpg"
        },

        "Monitor LG 27 pulgadas": {
            descripcion: "Monitor IPS Full HD de 27 pulgadas",
            categoria: "Monitores",
            marca: "LG",
            imagen: "monitorlg.jpg"
        },

        "Samsung Odyssey G5": {
            descripcion: "Monitor gaming QHD 165Hz",
            categoria: "Monitores",
            marca: "Samsung",
            imagen: "odyssey.jpg"
        },

        "Dell UltraSharp 27": {
            descripcion: "Monitor profesional 27 pulgadas 4K",
            categoria: "Monitores",
            marca: "Dell",
            imagen: "dellmonitor.jpg"
        },

        "Teclado Logitech MX Keys": {
            descripcion: "Teclado inalámbrico retroiluminado",
            categoria: "Periféricos",
            marca: "Logitech",
            imagen: "teclado.jpg"
        },

        "Ratón Logitech MX Master 3": {
            descripcion: "Ratón ergonómico inalámbrico",
            categoria: "Periféricos",
            marca: "Logitech",
            imagen: "raton.jpg"
        },

        "Webcam Logitech Brio": {
            descripcion: "Webcam 4K para videollamadas",
            categoria: "Periféricos",
            marca: "Logitech",
            imagen: "webcam.jpg"
        },

        "Auriculares HyperX Cloud III": {
            descripcion: "Auriculares gaming con micrófono",
            categoria: "Periféricos",
            marca: "HyperX",
            imagen: "hyperx.jpg"
        },

        "Impresora HP LaserJet": {
            descripcion: "Impresora láser multifunción",
            categoria: "Impresoras",
            marca: "HP",
            imagen: "impresora.jpg"
        },

        "Epson EcoTank ET-2850": {
            descripcion: "Impresora multifunción con depósito de tinta",
            categoria: "Impresoras",
            marca: "Epson",
            imagen: "epson.jpg"
        },

        "Brother DCP-L2530DW": {
            descripcion: "Multifunción láser monocromo WiFi",
            categoria: "Impresoras",
            marca: "Brother",
            imagen: "brother.jpg"
        }
    };


    /* 
       Si el producto seleccionado existe dentro del objeto datos,
       rellenamos automáticamente los campos.
    */

    if(datos[producto]){

        // Rellena la descripción
        descripcion.value = datos[producto].descripcion;

        // Rellena la categoría
        categoria.value = datos[producto].categoria;

        // Rellena la marca
        marca.value = datos[producto].marca;

        // Guarda el nombre del archivo de imagen en el input oculto
        imagen.value = datos[producto].imagen;

        // Muestra la vista previa de la imagen
        preview.src = "../img/" + datos[producto].imagen;
        preview.style.display = "block";

        // Muestra un texto bonito debajo de la imagen
        nombreImagen.innerHTML = datos[producto].marca + " - " + producto;

    }else{

        // Si no se selecciona ningún producto, se limpian los campos
        descripcion.value = "";
        categoria.value = "";
        marca.value = "";
        imagen.value = "";

        // Ocultamos la imagen
        preview.src = "";
        preview.style.display = "none";

        // Borramos el texto debajo de la imagen
        nombreImagen.innerHTML = "";
    }
}















// function validarRegistro(){

//     let precio = document.getElementById("precio");
//     let cantidad = document.getElementById("cantidad");
//     let mensaje = document.getElementById("mensajeError");

//     mensaje.innerHTML = "";

//     let decimal = /^[0-9]+(\.[0-9]{1,2})?$/;

//     if(!decimal.test(precio.value)){
//         mensaje.innerHTML = "El precio debe ser decimal. Ejemplo: 899.99";
//         return false;
//     }

//     if(parseFloat(precio.value) < 0){
//         mensaje.innerHTML = "El precio no puede ser negativo.";
//         return false;
//     }

//     if(parseInt(cantidad.value) <= 0){
//         mensaje.innerHTML = "La cantidad no puede ser 0.";
//         return false;
//     }

//     return true;
// }

// function validarPrecio(){

//     let precio = document.getElementById("precio");
//     let mensaje = document.getElementById("mensajeError");

//     mensaje.innerHTML = "";

//     let decimal = /^[0-9]+(\.[0-9]{1,2})?$/;

//     if(!decimal.test(precio.value)){
//         mensaje.innerHTML = "El precio debe ser decimal. Ejemplo: 999.99";
//         return false;
//     }

//     if(parseFloat(precio.value) < 0){
//         mensaje.innerHTML = "El precio no puede ser negativo.";
//         return false;
//     }

//     return true;
// }

// // FUNCION PARA QUE SE RELLENE SOLO EL FORMULARIO

// function rellenarProducto(){

//     let producto = document.getElementById("producto").value;

//     let descripcion = document.getElementById("descripcion");
//     let categoria = document.getElementById("categoria");
//     let marca = document.getElementById("marca");
//     let imagen = document.getElementById("imagen");
//     let preview = document.getElementById("previewImagen");

//     let datos = {
//         "Portátil Lenovo IdeaPad": {
//             descripcion: "Intel i7, 16GB RAM y SSD 512GB",
//             categoria: "Portátiles",
//             marca: "Lenovo",
//             imagen: "Lenovo.jpg"
//         },
//         "MacBook Air M4": {
//             descripcion: "Chip Apple Silicon, 16GB RAM y SSD 512GB",
//             categoria: "Portátiles",
//             marca: "Apple",
//             imagen: "macbook.jpg"
//         },
//         "RTX 5070": {
//             descripcion: "Tarjeta gráfica de 12GB",
//             categoria: "Componentes",
//             marca: "NVIDIA",
//             imagen: "tarjetagraficaRTX.jpg"
//         },
//         "SSD Samsung 1TB": {
//             descripcion: "Disco SSD NVMe de 1TB",
//             categoria: "Almacenamiento",
//             marca: "Samsung",
//             imagen: "ssdSamsung1TB.jpg"
//         },
//         "Monitor LG 27 pulgadas": {
//             descripcion: "Monitor IPS Full HD de 27 pulgadas",
//             categoria: "Monitores",
//             marca: "LG",
//             imagen: "monitorlg.jpg"
//         },
//         "Teclado Logitech MX Keys": {
//             descripcion: "Teclado inalámbrico retroiluminado",
//             categoria: "Periféricos",
//             marca: "Logitech",
//             imagen: "teclado.jpg"
//         },
//         "Ratón Logitech MX Master 3": {
//             descripcion: "Ratón ergonómico inalámbrico",
//             categoria: "Periféricos",
//             marca: "Logitech",
//             imagen: "raton.jpg"
//         },
//         "Impresora HP LaserJet": {
//             descripcion: "Impresora láser multifunción",
//             categoria: "Impresoras",
//             marca: "HP",
//             imagen: "impresora.jpg"
//         }
//     };

//     if(datos[producto]){
//         descripcion.value = datos[producto].descripcion;
//         categoria.value = datos[producto].categoria;
//         marca.value = datos[producto].marca;
//         imagen.value = datos[producto].imagen;

//         preview.src = "../img/" + datos[producto].imagen;
//         preview.style.display = "block";
//         // Mostrar nombre comercial debajo de la imagen
//         document.getElementById("nombreProductoImagen").innerHTML =
//         datos[producto].marca + " - " + producto;


//     }else{
//         descripcion.value = "";
//         categoria.value = "";
//         marca.value = "";
//         imagen.value = "";
//         preview.style.display = "none";
//         // Borrar el texto cuando no haya producto seleccionado
//         document.getElementById("nombreProductoImagen").innerHTML = "";
//     }
// }