
check:
	COMPOSER_MEMORY_LIMIT=-1 composer lint
	COMPOSER_MEMORY_LIMIT=-1 composer phpcs
	COMPOSER_MEMORY_LIMIT=-1 composer psalm
fix:
	COMPOSER_MEMORY_LIMIT=-1 composer phpcbf
analyze:
	COMPOSER_MEMORY_LIMIT=-1 composer psalm
test:
	COMPOSER_MEMORY_LIMIT=-1 composer test
