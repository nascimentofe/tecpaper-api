<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="http://chadamanu.tk/tecpaper/img/logo_api.png" width="150" alt="">
    </a>
</p>

## About TecPaper

"TecPaper - API" is a REST API, built on [Laravel 8](https://laravel.com/docs/8.x/installation)

Built to meet the requirements of any type of platform. Able to perform the 4 operations of the REST protocol: GET, POST, PUT and DELETE.

Field | Description
------|------------
**id** | Access key for the registered product.
name | The name of product.
description | A brief description of the registered product.
price | The price of product.
image | Product display image.
pass | Administrator password to delete all database records.

###

## 1. Get Product (GET)

###
- #### Specific product
```url
    https://linkdaapi.com/products/get/{id}
```

```JSON
{
    "id" : "7891040091027",
    "name" : "Mini post-it",
    "description" : "Notas auto-adesivas removíveis. 4 blocos de 100 folhas.",
    "price" : 4.25
}
```
###
- #### All products
```URL
    https://linkdaapi.com/products/get/
```

```JSON
[
    {
        "id" : "7891040091027",
        "name" : "Mini post-it",
        "description" : "Notas auto-adesivas removíveis. 4 blocos de 100 folhas.",
        "price" : 4.25
    },
    {
        "id" : "1189888888027",
        "name" : "Cola em bastão",
        "description" : "Notas auto-adesivas removíveis. 4 blocos de 100 folhas.",
        "price" : 7.60
    },
    {
        "id" : "00111019289121027",
        "name" : "Corretivo Líquido",
        "description" : "Notas auto-adesivas removíveis. 4 blocos de 100 folhas.",
        "price" : 13.90
    }
] 
```
##
 ## 2. New Product (POST)
###

```URL
https://linkdaapi.com/products/post/
```

- #### With Json (But no image)
```JSON
{
    "id" : "7891040091027",
    "name" : "Mini post-it",
    "description" : "Notas auto-adesivas removíveis. 4 blocos de 100 folhas.",
    "price" : 4.25
}
```
```JSON
{ // SUCCESS
    "result": "OK",
    "code": 200
}
```
```JSON
{ // ERROR
    "result": "ERROR",
    "code": 404
}
```
**To include an image in the product and send it to the database, it is necessary to send it as Post multipart / form-data.**

- #### Example with [Ion](https://github.com/koush/ion) (Android)
```JAVA
    Ion.with(getContext())
        .load("https://linkdaapi.com/products/post/")
        .setMultipartParameter("id", "7891040091027")
        .setMultipartParameter("name", "Mini post-it")
        .setMultipartParameter("description", "Notas auto-adesivas removíveis. 4 blocos de 100 folhas.")
        .setMultipartParameter("price", 4.25)
        .setMultipartFile("archive", "application/zip", new File("/sdcard/filename.zip"))
        .asJsonObject()
        .setCallback(...)
```
```JSON
{ // SUCCESS
    "result": "OK",
    "code": 200
}
```
```JSON
{ // ERROR
    "result": "ERROR",
    "code": 404
}
```
## 3. Update Product

```URL
https://linkdaapi.com/products/put/
```
**The API is able to check the data provided and update the database, only what is necessary.**
<br>
**You must pass a JSON to update a record. The process is similar to when you are going to insert a new product.**
