## Mini integráció a SalesAutopilot API-jával

### Install

    docker compose up -d
    docker exec -it sapi_app bash
    composer install
    cp .env.example .env
    php artisan key:generate

### Mock mode
SAPI_MOCK=true enables offline development without API access.

### Functional requirements:

    1. The application should request a SAPI API key pair (username + password), or read it from .env.
    2. List the lists in the given account (list name, size, creation date).
    3. It should be possible to select a list and view its first 20 subscribers.
    4. The list view should be able to filter or sort the subscribers in some way

### Error handling requirements:

    Invalid / bad API key:
        A clear error message, not just a white page or raw JSON

    Empty list (0 subscribers):
        Do not crash, do not leave a blank page without explanation

    SAPI API not responding / timeout:
        Graceful degradation — the application should not freeze Rate limit reached (APIv2: parallel request prohibited)    
