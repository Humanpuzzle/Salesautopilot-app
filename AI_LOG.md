# AI_LOG.md

Ez a dokumentum a fejlesztés során használt AI eszközökkel (ChatGPT, GitHub Copilot) folytatott lényegesebb interakciókat és döntési pontokat tartalmazza.

---

## 1. Projekt indulás – Docker + Laravel setup

**Kérdés:**
    Hogyan érdemes nekiállni a feladatnak step-by-step, Dockerrel?

**AI válasz lényege:**
- Docker alapú környezet javasolt
- Laravel minimal setup
- Service layer használata
- REST API integráció Guzzle-lel

**Eredmény:**
- Docker telepítése
- Laravel projekt létrehozása `src` mappába
- Alap struktúra kialakítása

---

## 2. Composer / projekt struktúra probléma

**Hiba:**
    Project directory "/var/www/html/." is not empty.

**AI segítség:**
- Projektet ne rootba, hanem `src/` mappába generáljam

**Döntés:**
- Laravel install áthelyezése `src` könyvtárba

---

## 3. SQLite hiba (readonly database)

**Hiba:**
attempt to write a readonly database

**AI segítség:**
- Docker volume / permission probléma
- `chmod` és file ownership javítása

**Eredmény:**
- adatbázis írhatóvá tétele

---

## 4. SAPI API integráció – Guzzle + Auth

**Kérdés:**
    .env-ben tárolt user/pass használható-e Guzzle-lel?

**AI válasz:**
- igen, `auth` configban használható
- Basic Auth headerként kerül elküldésre

**Döntés:**
- config/services.php használata
- credentials session fallback

---

## 5. Error handling stratégia

**Követelmény:**
- 401 → hibás API kulcs
- timeout → ne fagyjon le
- rate limit → kezelni

**AI javaslat:**
- egyedi `SapiException`
- HTTP status mapping

**Eredmény:**
- centralizált hibakezelés
- user-friendly hibaüzenetek Blade-ben

---

## 6. Middleware + login flow

**Probléma:**
    Login után visszadob a login oldalra

**AI elemzés:**
- session kulcs mismatch
- middleware rossz route check

**Fix:**
- session kulcs egységesítése (`sapi_username`, `sapi_password`)
- middleware kivételek pontosítása

---

## 7. Filter + Sort implementáció

**Kérdés:**
    Hogyan kezeljem a search + sort kombinációt?

**AI javaslat:**
- API search külön endpoint
- sort fallback PHP oldalon

**Döntés:**
- search → API
- sort → ha kell, Laravel collection

---

## 8. Request API használat (deprecated get())

**Hiba:**
    $request->get() deprecated / undefined method 

**AI válasz:**
- input() vagy query() használata

**Fix:**
    $search = $request->input('search');

---

## 9. Controller túl komplex

**AI javaslat:**

service layer szétbontása
SapiClient bevezetése

**Döntés:**
HTTP logika kiszervezése külön class-ba

---

## 10. SapiClient refactor

**Eredeti állapot:**
minden service-ben Guzzle init
duplikált try/catch

**AI javaslat:**
dedikált SapiClient
centralizált error handling

**Eredmény:**
tiszta service layer
DRY megoldás

---

## 11. API limitáció felismerése

**Kérdés:**
    Hol van list size / created_at?

**AI válasz:**
endpoint nem adja vissza

**Döntés:**
N/A megjelenítés
reflection.md-ben dokumentálva

## 12. DTO kérdés

**AI javaslat:**
DTO layer bevezetése

**Döntés:**
nem implementálom most
REFLECTION.md-ben javaslatként szerepel

--- 

## 13. UI döntések

**AI javaslat:**
Tailwind gyors setup

**Döntés:**
CDN használata
production-ben build tool javasolt

---
---
## Összegzés

Az AI eszközöket nem csak kódgenerálásra használtam, hanem:

- architekturális döntések validálására
- hibák gyors azonosítására
- alternatív megoldások összehasonlítására

Több esetben szükség volt az AI válaszainak felülvizsgálatára és pontosítására, különösen az API működésének értelmezésekor és a Laravel specifikus problémák esetén.