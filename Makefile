
.PHONY: dist

install-dev:
	sudo curl -o /usr/local/bin/box -sL https://github.com/humbug/box/releases/download/3.8.5/box.phar
	sudo chmod +x /usr/local/bin/box

dist:
	bash scripts/build.sh
	sudo cp dist/propan.phar /usr/local/bin/propan

test-run-local:
	php bin/propan run --port 8080

test-build:
	php bin/propan build
