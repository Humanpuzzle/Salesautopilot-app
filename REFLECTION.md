# REFLECTION.md

A feladat megvalósítása során törekedtem egy tiszta, rétegezett architektúra kialakítására, ahol az API kommunikáció, az üzleti logika és a megjelenítés jól elkülönül.

A 4. pontban szereplő szűrés és rendezés követelményt úgy értelmeztem, hogy a felhasználó képes legyen email alapján keresni, valamint az eredményeket különböző mezők szerint rendezni. A SalesAutopilot API korlátozásai miatt a keresés és a rendezés nem minden esetben kombinálható közvetlenül API szinten, ezért a keresési eredményeket szükség esetén alkalmazás oldalon rendezem. Ez egy tudatos kompromisszum volt a funkcionalitás biztosítása érdekében.

A fejlesztés során több AI eszközt is használtam (elsősorban ChatGPT és GitHub Copilot), eltérő célokra. A Copilot főként gyors kódgenerálásban és boilerplate írásban segített, míg a ChatGPT-t inkább architekturális döntések átgondolására és hibakeresésre használtam. Az AI különösen hasznos volt a Laravel struktúra finomításában és a service layer kialakításában.

Ugyanakkor több esetben szükség volt az AI által javasolt megoldások felülvizsgálatára és korrekciójára, különösen a SAPI API működésének pontos értelmezése, valamint a hibakezelési logika kialakítása során. Ezekben az esetekben manuális validációt és logolást használtam a helyes működés ellenőrzésére.

A projekt során egy dedikált SapiClient réteget vezettem be, amely centralizálja az autentikációt, a HTTP kommunikációt és a hibakezelést. Ennek köszönhetően a service réteg kizárólag az üzleti logikára fókuszál, ami javítja a kód olvashatóságát és karbantarthatóságát.

A Docker környezet beállítása során ideiglenes fájlkezelési problémát tapasztaltam (temp könyvtár és jogosultságok), amelyet jogosultságkezeléssel és PHP konfiguráció módosításával oldottam meg.

A frontend esetében Tailwind CDN megoldást alkalmaztam, mivel ez gyors és egyszerű integrációt tett lehetővé a feladat jellegéhez igazodva. Egy production környezetben azonban inkább Vite + Tailwind build pipeline-t alkalmaznék a bundle méret és a testreszabhatóság optimalizálása érdekében.

A dokumentáció alapján a SalesAutopilot /getlists endpoint nem biztosít információt a listák méretéről és létrehozási dátumáról, ezért ezeket az adatokat nem tudtam megjeleníteni. A felület ennek megfelelően kezeli a hiányzó adatokat, és fel van készítve arra, hogy az API bővülése esetén ezek könnyen integrálhatók legyenek.

A fejlesztés során a SAPI API elérés hiánya miatt mock válaszokat használtam a dokumentáció alapján. 
A rendszer konfigurációval képes váltani valós és mock mód között, így a fejlesztés és tesztelés API hozzáférés nélkül is biztosított.

Ha újra készíteném a megoldást, egy következő iterációban bevezetnék egy dedikált DTO vagy Resource réteget a feliratkozók adatainak normalizálására. Jelenleg ez a logika a controllerben található, ami működőképes, de nem ideális. Egy ilyen réteg egységes adatstruktúrát biztosítana a view számára, és tovább csökkentené a controller felelősségét, különösen mivel a külső API mezőnevei nem minden esetben konzisztensek.