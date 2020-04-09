# CORS

Script feito apenas para minhas aplicações JS não sofrerem ao fazer chamadas para outros hosts.

```javascript
fetch("https://local.que.voce.baixou.o.projeto.com.br/", {
    method: "POST",
    mode  : "cors",
    cache : "default",
    body  : JSON.stringify([
        {
            url : "https://url1.com.br",
            body: {
                username: username,
                password: password
            }
        },
        {
            url : "https://url2.com.br",
            body: {
                username: username,
                password: password
            }
        },
    ])
});
```

O retorno é uma string JSON o output de cada chamada realizada em array.