const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');
const { MongoClient, ObjectId } = require('mongodb');

const app = express();
const port = 3000;
const uri = 'mongodb://localhost:27017';
const client = new MongoClient(uri, { useNewUrlParser: true, useUnifiedTopology: true });

app.use(bodyParser.json());
app.use(cors());

let db, productosCollection;

async function connectDB() {
  await client.connect();
  db = client.db('pruebas');
  productosCollection = db.collection('prueba_productos');
  console.log("Conectado a MongoDB");
}

connectDB().catch(console.error);

// Obtener todos los productos
app.get('/productos', async (req, res) => {
  const productos = await productosCollection.find({}).toArray();
  res.json(productos);
});

// Agregar un nuevo producto
app.post('/productos', async (req, res) => {
  const nuevoProducto = req.body;
  await productosCollection.insertOne(nuevoProducto);
  res.json(nuevoProducto);
});

// Eliminar un producto
app.delete('/productos/:id', async (req, res) => {
  const id = req.params.id;
  await productosCollection.deleteOne({ _id: new ObjectId(id) });
  res.json({ message: 'Producto eliminado' });
});

app.listen(port, () => {
  console.log(`Servidor escuchando en http://localhost:${port}`);
});
