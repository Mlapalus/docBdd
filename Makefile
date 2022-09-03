.PHONY: docBdd
docBdd:
	docker run --rm --network="host" -v $(PWD)/output:/output andrewjones/schemaspy-postgres:latest -host localhost -port 5678 -u app -p '!ChangeMe!' -db app -s public

.PHONY: bdd
bdd:
	php bin/console doctrine:database:drop --force --env=test
	php bin/console doctrine:database:create --env=test
	php bin/console doctrine:migration:migrate --env=test --no-interaction