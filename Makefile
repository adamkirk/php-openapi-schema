IMG_NAME ?= adamkirk/php-openapi-schema:local
IMG_BASE_VERSION ?= 8.0
DKR_BUILD_BASE=docker build --build-arg "IMG_BASE_VERSION=$(IMG_BASE_VERSION)" -t $(IMG_NAME)
DKR_BUILD_NO_CACHE=$(DKR_BUILD_BASE) --no-cache .
DKR_BUILD=$(DKR_BUILD_BASE) .

DOCS_DC=docker compose -p php-openapi-schema-docs -f ./docker-compose.docs.yml

DKR_SHELL=docker run -it --rm -w /app -v "$(shell pwd):/app" $(IMG_NAME) bash

.PHONY: build
build:
	$(DKR_BUILD)

.PHONY: build-no-cache
build-no-cache:
	$(DKR_BUILD_NO_CACHE)

PHONY: shell
shell:
	$(DKR_SHELL)

.PHONY: docs-up
docs-up:
	$(DOCS_DC) up -d

.PHONY: docs-down
docs-down:
	$(DOCS_DC) down --remove-orphans

.PHONY: docs-restart
docs-restart: docs-down docs-up