.PHONY: docBdd

docBdd:
	docker run --rm --network="host" -v $(PWD)/output:/output andrewjones/schemaspy-postgres:latest -host localhost -port 5678 -u app -p '!ChangeMe!' -db app -s public
