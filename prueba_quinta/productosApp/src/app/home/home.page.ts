import { Component, OnInit } from '@angular/core';
import { ProductoServiceTsService } from '../services/producto.service.ts.service';

interface Producto {
  _id?: string;
  nombre: string;
  precio: number;
  cantidad: number;
}

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
})
export class HomePage implements OnInit {
  productos: Producto[] = [];
  nuevoProducto: Producto = { nombre: '', precio: 0, cantidad: 0 };

  constructor(private productoService: ProductoServiceTsService) {}

  ngOnInit() {
    this.obtenerProductos();
  }

  obtenerProductos() {
    this.productoService.getProductos().subscribe((data) => {
      this.productos = data;
    });
  }

  agregarProducto() {
    this.productoService.addProducto(this.nuevoProducto).subscribe(() => {
      this.nuevoProducto = { nombre: '', precio: 0, cantidad: 0 };
      this.obtenerProductos();
    });
  }

  eliminarProducto(id: any) {
    this.productoService.deleteProducto(id).subscribe(() => {
      this.obtenerProductos();
    });
  }
}
