<steps>
1. Create or modify tests following <best-practices>
2. Verify that the tests pass as expected by running the tests as per <how-to-run>
2.1. If they don't pass, return to step 1, adjusting as necessary so that only the broken tests pass.
2.2. If the tests are passing, the modifications have been completed.
</steps>

<best-practices to="Vitest Tests">
- Keep tests close to the component implementation in `__tests__`
- Test different scenarios and edge cases
- Mock external dependencies when necessary to unitary tests
- Use Gherkin notation using the `test` function instead of `it`
</best-practices>

<how-to-run>
- Execute the command `docker exec meraki-shop-dev-php-fpm npm test`
</how-to-run>
