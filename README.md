# LibriREST

API REST sviluppata in PHP per la gestione CRUD di una tabella MySQL, utilizzando PDO e risposte in formato JSON.

---

## Configurazione database

Il file `pdo.php` presente nella repository non contiene credenziali funzionanti.

Per far funzionare il progetto è necessario modificare il file inserendo i propri parametri di connessione al database (host, nome database, utente e password), come indicato all'interno del file stesso.

---

## Funzionalità

- GET → recupero dei libri
- POST → inserimento nuovo libro
- PUT → aggiornamento libro
- DELETE → eliminazione libro
