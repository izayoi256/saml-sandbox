init:
	cp -n idp.dist.ini idp.ini && \
	cp -n sp.dist.ini sp1.ini && \
	cp -n sp.dist.ini sp2.ini && \
	yes "" | openssl req -x509 -sha256 -nodes -days 7300 -newkey rsa:2048 -keyout idp/storage/samlidp/key.pem -out idp/storage/samlidp/cert.pem && \
	yes "" | openssl req -x509 -sha256 -nodes -days 7300 -newkey rsa:2048 -keyout .certs/sp1.key.pem -out .certs/sp1.cert.pem && \
	yes "" | openssl req -x509 -sha256 -nodes -days 7300 -newkey rsa:2048 -keyout .certs/sp2.key.pem -out .certs/sp2.cert.pem && \
	cp .certs/sp1.cert.pem idp/storage/samlidp/sp1.cert.pem && \
	cp .certs/sp2.cert.pem idp/storage/samlidp/sp2.cert.pem && \
	docker-compose up -d --build && \
	docker-compose exec -u www-data idp composer install && \
	docker-compose exec -u www-data sp1 composer install && \
	docker-compose stop

dev:
	docker-compose up --build
