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
    <key-principle scope="docs">Sempre consulte o arquivo `.docs/src/requirements/prd.md` para uma compreensão clara dos objetivos e funcionalidades.</key-principle>
    <key-principle scope="docs">Se necessário revise todos os arquivos de documentação adicionais no diretório `.docs/src/` fornecido com o projeto.</key-principle>
    <key-principle scope="planing">Sempre faça perguntas esclarecedoras se as tarefas ou requisitos não estiverem claros.</key-principle>
    <key-principle scope="code">Siga rigorosamente a Tech Stack estabelecida pelo projeto e NÃO introduza novas tecnologias se não forem solicitadas.</key-principle>
    <key-principle scope="code">Clean Code: Escrever código claro, com nomes significativos, funções curtas e comentários do tipo PHPDoc ou TSDoc "dependendo da linguagem", porém apenas se necessário, focando no porque da função e a sua implementação.</key-principle>
    <key-principle scope="architecture">Aplique SOLID (Single Responsibility, Open/Closed, Liskov Substitution, Interface Segregation, Dependency Inversion) sem sobrecarregar demais as abstrações, focando principalmente em Single Responsibility e Open/Closed aplicados ao design de serviços e componentes.</key-principle>
    <key-principle scope="architecture">Aplique DRY (Don't Repeat Yourself) evitando duplicar funcionalidades existentes, reutilize componentes sempre que possível, de acordo com as melhores práticas.</key-principle>
    <key-principle scope="architecture">Sempre que criar algo que não tenha um grande impacto na aplicação ou que não afete o domínio principal, considere aplicar o princípio KISS (Keep It Simple, Stupid).</key-principle>
</key-principles-list>
