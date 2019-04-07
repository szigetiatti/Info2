# Info2
BME VIK- Informatika 2 című tárgyához szükséges féléves házim.

Megvalósítandó feladat egy "webalkalmazás", relációs adatbázissal, HTML,CSS,PHP technológiák segítségével.

Webshop

Házi feladatnak egy webshopot valósítanék meg, amiben az eladó tudja nyilvántartani az eladott termékeket, illetve azokat tudja módosítani, új eladást hozzáadni.
Az adatbázis tárolja a vevőket és a termékeket a következőképpen:

Vevő tábla:
    azonosító (idvevo)
    vezetéknév(vezeteknev)
    keresztnév(keresztnév)
    lakcím(lakcim)
    kártyaszám(kartyaszam)

Termék tábla:
    azonosító(termekid)
    terméknév(nev)
    darabszám(darab)
    leírás(leiras)
    ár(ar)
    gyártó(gyarto)
    
Kapcsolótábla (megvasarolta): melyik terméket melyik vevő vásárolta meg. 1 terméket 1 vevő többször is megvásárolhat
    azonosító (idmegvasarolta)
    vevőre vonatkozó külső azonosító (vevoid)
    termékre vonatkozó külső azonosító (termekid)
    vásárlási dátum (vasarlasidatum)

