const { MongoClient } = require('mongodb');

async function main() {
  const uri = 'mongodb://localhost:27017';
  const client = new MongoClient(uri, { useNewUrlParser: true, useUnifiedTopology: true });

  try {
    // Conéctate al cliente de MongoDB
    await client.connect();
    console.log("Conectado a MongoDB");

    const database = client.db('pruebas');
    const coleccion = database.collection('prueba_productos');

    // Inserta documentos en la colección 'productos'
    await insertarProductos(coleccion);

    // Busca el precio de un producto por su nombre
    const nombreProducto = 'Pony malta';
    const precio = await obtenerPrecioProducto(coleccion, nombreProducto);

    if (precio !== null) {
      console.log(`El precio de ${nombreProducto} es ${precio}`);
    } else {
      console.log(`El producto ${nombreProducto} no se encontró en la colección.`);
    }
  } finally {
    // Cierra la conexión a MongoDB
    await client.close();
  }
}

async function insertarProductos(coleccion) {
  const productos = [
    { id: 1, nombre: 'Coca cola', precio: 3000, cantidad: 100 },
    { id: 2, nombre: 'Pony malta', precio: 2000, cantidad: 200 },
    { id: 3, nombre: 'Colombiana', precio: 2000, cantidad: 300 },
  ];

  await coleccion.insertMany(productos);
  console.log("Productos insertados");
}

async function obtenerPrecioProducto(coleccion, nombreProducto) {
  const producto = await coleccion.findOne({ nombre: nombreProducto });

  if (producto) {
    return producto.precio;
  } else {
    return null;
  }
}

main().catch(console.error);
