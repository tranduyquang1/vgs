build:
	docker-compose build $(app)

start:
	docker-compose up -d $(app)

restart:
	docker-compose stop $(app)
	docker-compose up -d $(app)

stop:
	docker-compose stop $(app)

remove:
	docker-compose stop $(app)
	docker-compose rm $(app)