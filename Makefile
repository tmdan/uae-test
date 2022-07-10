#export APP_NAME=uae-test-app
include app/.env
export $(shell sed 's/=.*//' app/.env)

start:
	make ub && make m
m:
	docker exec -it $(APP_NAME) php artisan migrate --seed
d:
	docker-compose down
u:
	docker compose --env-file app/.env up -d
ub:
	docker compose build && docker compose --env-file app/.env up -d
ub-no-cache: # no cache, before uploading to AWS
	docker compose build --no-cache && docker compose --env-file app/.env up -d
bash:
	docker exec -it $(APP_NAME)-app bash





ubf:
	docker-compose up -d --build --force-recreate
tinker:
	docker exec -it $(APP_NAME)-app php artisan tinker
b:
	docker build -t 711770257294.dkr.ecr.us-east-2.amazonaws.com/uae-test-horizon:latest ./docker/horizon/ && \
	docker build -t 711770257294.dkr.ecr.us-east-2.amazonaws.com/uae-test-horizon:latest ./docker/app/
push:
	docker push 711770257294.dkr.ecr.us-east-2.amazonaws.com/uae-test-app:latest && \
   	docker push 711770257294.dkr.ecr.us-east-2.amazonaws.com/uae-test-app-nginx:latest && \
   	docker push 711770257294.dkr.ecr.us-east-2.amazonaws.com/uae-test-horizon:latest

