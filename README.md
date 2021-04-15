<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="http://tecpaper.tk/tecpaper/public/img/ic_launcher.png" width="150" alt="">
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



## 1. Get Product (GET)


- #### Specific product
```url
    http://tecpaper.tk/tecpaper/public/api/products?id={id}
```

```JSON
// http://tecpaper.tk/tecpaper/public/api/products?id=1122
{ 
    "id": 1122,
    "name": "Sapato social",
    "description": "Utilizado para trabalho e festas reservadas.",
    "price": 39.9,
    "image": "/tecpaper/public/img/upload/1122/image.jpg",
    "created_at": "2021-03-25T15:13:05.000000Z",
    "updated_at": "2021-03-25T18:09:41.000000Z"
}
```

- #### All products
```url
    http://tecpaper.tk/tecpaper/public/api/products/
```

```JSON
[
    {
        "id" : "7891040091027",
        "name" : "Mini post-it",
        "description" : "Notas auto-adesivas removíveis. 4 blocos de 100 folhas.",
        "price" : 4.25,
        "image": "/img/7891040091027/image.jpg",
        "created_at": "2021-03-25T15:13:05.000000Z",
        "updated_at": "2021-03-25T18:09:41.000000Z"
    },
    {
        "id" : "1189888888027",
        "name" : "Cola em bastão",
        "description" : "Notas auto-adesivas removíveis. 4 blocos de 100 folhas.",
        "price" : 7.60,
        "image" : "",
        "created_at": "2021-03-25T15:13:05.000000Z",
        "updated_at": "2021-03-25T18:09:41.000000Z"
    },
    {
        "id" : "00111019289121027",
        "name" : "Corretivo Líquido",
        "description" : "Notas auto-adesivas removíveis. 4 blocos de 100 folhas.",
        "price" : 13.90,
        "image": "/img/00111019289121027/image.jpg",
        "created_at": "2021-03-25T15:13:05.000000Z",
        "updated_at": "2021-03-25T18:09:41.000000Z"
    }
] 
```

 ## 2. New Product (POST)


```URL
http://tecpaper.tk/tecpaper/public/api/products/
```

**To include an image in the product and send it to the database, it is necessary to send it as Post multipart / form-data.**

- #### Example with [Ion](https://github.com/koush/ion) (Android)
```JAVASCRIPT
    Ion.with(getContext())
        .load("http://tecpaper.tk/tecpaper/public/api/products/")
        .setMultipartParameter("id", "7891040091027")
        .setMultipartParameter("name", "Mini post-it")
        .setMultipartParameter("description", "Notas auto-adesivas removíveis. 4 blocos de 100 folhas.")
        .setMultipartParameter("price", 4.25)
        .setMultipartFile("image", "image/jpeg", new File("/sdcard/filename.jpeg"))
        .asJsonObject()
        .setCallback(...)
```

- #### Example with [AsyncHttpClient](https://loopj.com/android-async-http/) (Android)

```JAVASCRIPT
    RequestParams params = new RequestParams();
        params.put("id", "7891040091027");
        params.put("name", "Mini post-it");
        params.put("description", "Notas auto-adesivas removíveis. 4 blocos de 100 folhas.");
        params.put("price", 4.25);
        params.put("image", new FileInputStream(new File("/sdcard/filename.jpeg")), "filename.jpg");
        
        new AsyncHttpClient()
            .post("http://tecpaper.tk/tecpaper/public/api/products/", 
                params, 
                new JsonHttpResponseHandler(){
                @Override
                public void onSuccess(int statusCode, Header[] headers, JSONObject response) {
                    try {
                        Toast.makeText(mContext, response.getString("result"), Toast.LENGTH_LONG).show();
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
        });
```


```JSON
{ // SUCCESS
    "result" : "REGISTRO INSERIDO",
    "code" : 200
}
```

## 3. Update Product (POST)

```URL
http://tecpaper.tk/tecpaper/public/api/products/
```
**The API is able to check the data provided and update the database, only what is necessary.**
<br>

- #### Example with [Ion](https://github.com/koush/ion) (Android)
```JAVASCRIPT
    Ion.with(getContext())
        .load("http://tecpaper.tk/tecpaper/public/api/products/")
        .setMultipartParameter("id", "7891040091027")
        .setMultipartParameter("name", "Mini post-it")
        .setMultipartParameter("description", "Notas auto-adesivas removíveis. 4 blocos de 100 folhas.")
        .setMultipartParameter("price", 4.25)
        .setMultipartParameter("update", "true")
        .setMultipartFile("image", "image/jpeg", new File("/sdcard/filename.jpeg"))
        .asJsonObject()
        .setCallback(...)
```

- #### Example with [AsyncHttpClient](https://loopj.com/android-async-http/) (Android)

```PHP
    RequestParams params = new RequestParams();
        params.put("id", "7891040091027");
        params.put("name", "Mini post-it");
        params.put("description", "Notas auto-adesivas removíveis. 4 blocos de 100 folhas.");
        params.put("price", 4.25);
        params.put("update", "true");
        params.put("image", new FileInputStream(new File("/sdcard/filename.jpeg")), "filename.jpg");
        
        new AsyncHttpClient()
            .post("http://tecpaper.tk/tecpaper/public/api/products/", 
                params, 
                new JsonHttpResponseHandler(){
                @Override
                public void onSuccess(int statusCode, Header[] headers, JSONObject response) {
                    try {
                        Toast.makeText(mContext, response.getString("result"), Toast.LENGTH_LONG).show();
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
        });
```
```JSON
{ // SUCCESS
    "result" : "REGISTRO ATUALIZADO",
    "code" : 200
}
```

## 4. Delete Product (GET)

- #### Especific Product

```url
http://tecpaper.tk/tecpaper/public/api/products?id={id}&pass={pass}
```

```JSON
// http://tecpaper.tk/tecpaper/public/api/products?id=123&pass=#####
{ 
    "result" : "REGISTRO DELETADO",
    "code" : 200
}
```
```JSON
// http://tecpaper.tk/tecpaper/public/api/products?id=123&pass=123
{ 
    "result" : "ACESSO NAO PERMITIDO",
    "code": 400
}
```

## 5. Support

Any questions or suggestions, send an email to: ***fenascimentodev@gmail.com***
