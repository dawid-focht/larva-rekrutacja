# Product API Documentation

## Overview
This API provides endpoints for managing products.

## Endpoints

### List Products
- **URL**: `/api/products`
- **Method**: `GET`
- **Parameters**: 
  - `search` (optional) - search term
  - `min_price` (optional)
  
**Response**: Array of products

### Get Product
- **URL**: `/api/product/{id}`
- **Method**: `GET`

**Response**: Product object

### Create Product
- **URL**: `/api/products/create`
- **Method**: `POST`
- **Body**:
  ```json
  {
    "name": "Product Name",
    "price": 100,
    "quantity": 10
  }
  ```

### Update Product
- **URL**: `/api/products/update/{id}`
- **Method**: `PUT`
- **Body**: Same as create

### Delete Product
- **URL**: `/api/product/delete/{id}`
- **Method**: `DELETE`

### Mass Update
- **URL**: `/api/products/mass-update`
- **Method**: `POST`

### Statistics
- **URL**: `/api/products-stats`
- **Method**: `GET`

## Notes
- All endpoints return JSON
- Authentication required for some endpoints
- Prices are in PLN

