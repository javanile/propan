#!make

push:
	git config credential.helper 'cache --timeout=3600'
	git pull
	git add .
	git commit -am "push"
	git push

install-dev:
	sudo curl -o /usr/local/bin/box -sL https://github.com/humbug/box/releases/download/3.8.5/box.phar
	sudo chmod +x /usr/local/bin/box

.PHONY: dist
dist:
	bash scripts/build.sh
	sudo cp dist/propan.phar /usr/local/bin/propan

.PHONY: docs
docs:
	mkdocs gh-deploy --remote-branch gh-pages

test-run-local:
	php bin/propan run --port 8080

test-build:
	php bin/propan build .

fork:
	curl -sL git.io/fork.sh | bash -
