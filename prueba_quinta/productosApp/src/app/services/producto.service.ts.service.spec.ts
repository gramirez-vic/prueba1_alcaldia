import { TestBed } from '@angular/core/testing';

import { ProductoServiceTsService } from './producto.service.ts.service';

describe('ProductoServiceTsService', () => {
  let service: ProductoServiceTsService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ProductoServiceTsService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
