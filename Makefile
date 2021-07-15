psalm:
	vendor/bin/psalm
test:
	vendor/bin/phpunit
test.coverage:
	vendor/bin/phpunit --coverage-html coverage
format:
	vendor/bin/php-cs-fixer fix --allow-risky=yes

.PHONY: test
