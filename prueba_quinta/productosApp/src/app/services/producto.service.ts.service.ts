import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

interface Producto {
  id?: string;
  nombre: string;
  precio: number;
  cantidad: number;
}

@Injectable({
  providedIn: 'root'
})
export class ProductoServiceTsService {

  private apiUrl = 'http://localhost:3000/productos';

  constructor(private http: HttpClient) {}

  getProductos(): Observable<Producto[]> {
    return this.http.get<Producto[]>(this.apiUrl);
  }

  addProducto(producto: Producto): Observable<Producto> {
    return this.http.post<Producto>(this.apiUrl, producto);
  }

  deleteProducto(id: string): Observable<any> {
    return this.http.delete(`${this.apiUrl}/${id}`);
  }
}
