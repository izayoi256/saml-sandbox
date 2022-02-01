```
$ make init # 鍵の生成やライブラリのインストール等 (初回のみ必要)
$ make dev # docker-composeで起動
```

- IDP: http://localhost:8000
- SP1: http://localhost:8080
- SP2: http://localhost:8888

ポート等を変更する場合は`.env.example`を`.env`にコピーして設定を変更する。
