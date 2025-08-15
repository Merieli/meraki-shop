# Core Principles

<about-the-project>
- See `README.md` for quick, general information about the project and its technologies.
- For more details about the project implementation, its requirements, database ER diagram and other details see the documents in `.docs/src`.
</about-the-project>

<structure to="Frontend">

- `resources/js/components`: Vue components separated by context of use, for example, if it is part of the product page it goes to the `products` folder, if it is part of a generic context that aims to prepare the product list cards it goes to `cards`, and so on.
- `resources/js/ui`: "Shadcn-inspired" Reka UI components copied for use in the project.
- `resources/js/composables`: has more general-purpose Vue composables, when it doesn't serve just a single component, or when there's no better place to organize them.</structure>

<structure to="Backend">

- `app/Http/Controllers/Api`: controllers for the project's API endpoints.
- `app/Repositories`: repositories for actions in the database.
- `app/Facades`: facades for the logger and project services.
- `app/Services`: services with project business rules.</structure>

<key-principles-list>
    <key-principle scope="docs">Always consult the `.docs/src/requirements/prd.md` file for a clear understanding of objectives and functionalities.</key-principle>
    <key-principle scope="docs">If necessary, review all additional documentation files in the `.docs/src/` directory provided with the project.</key-principle>
    <key-principle scope="planing">Always ask clarifying questions if tasks or requirements are not clear.</key-principle>
    <key-principle scope="code">Strictly follow the Tech Stack established by the project and DO NOT introduce new technologies if not requested.</key-principle>
    <key-principle scope="code">Clean Code: Write clear code with meaningful names, short functions, and PHPDoc or TSDoc comments "depending on the language", but only if necessary, focusing on the why of the function and its implementation.</key-principle>
    <key-principle scope="tests" in="frontend">Each component or function must have its tests close to its implementation in a `__tests__` directory, and scenarios should be written in Gherkin notation using `test` instead of `it`.</key-principle>
    <key-principle scope="architecture">Apply SOLID (Single Responsibility, Open/Closed, Liskov Substitution, Interface Segregation, Dependency Inversion) without overloading abstractions, focusing mainly on Single Responsibility and Open/Closed applied to service and component design.</key-principle>
    <key-principle scope="architecture">Apply DRY (Don't Repeat Yourself) by avoiding duplicating existing functionalities, reuse components whenever possible, according to best practices.</key-principle>
    <key-principle scope="architecture">Whenever creating something that does not have a significant impact on the application or does not affect the main domain, consider applying the KISS (Keep It Simple, Stupid) principle.</key-principle>
</key-principles-list>
