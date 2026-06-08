-- Phase 4.3: Query-Plan-Optimierung durch gezielte Indizes
-- Ziel: Highscore-, Ranking-, Login- und Aktivierungsabfragen beschleunigen.
--
-- Hinweis:
-- 1) Vorher ein Backup erstellen.
-- 2) In Wartungsfenster ausfuehren, da CREATE INDEX je nach Tabelle locken kann.
-- 3) Bei bereits bestehenden gleichnamigen Indizes die jeweilige Zeile entfernen.

-- -----------------------------------------------------------------------------
-- GAME
-- -----------------------------------------------------------------------------

-- Fuer MAX(score) je User/Mode/Level sowie Score-Lookups pro User.
CREATE INDEX idx_game_user_mode_level_score ON game (user_id, nov_mode, level, score);

-- Fuer periodische Highscore-/Ranking-Abfragen mit Zeitfilter.
CREATE INDEX idx_game_user_mode_level_beginn_score ON game (user_id, nov_mode, level, beginn, score);

-- Fuer globale Ranking-Abfragen nach Modus/Level mit Sortierung nach Score.
CREATE INDEX idx_game_mode_level_score_user ON game (nov_mode, level, score, user_id);

-- Fuer Aggregationen je User (z. B. beendete Spiele, Zeitfenster).
CREATE INDEX idx_game_user_ende ON game (user_id, ende);
CREATE INDEX idx_game_user_beginn ON game (user_id, beginn);

-- -----------------------------------------------------------------------------
-- NOV_USER
-- -----------------------------------------------------------------------------

-- Login-Lookup.
CREATE INDEX idx_nov_user_name_active ON nov_user (name, active);

-- Registrierung/Reset-Lookups.
CREATE INDEX idx_nov_user_email_mobile_active ON nov_user (email, mobile, active);

-- Leaderboard-Join mit mobile-Filter.
CREATE INDEX idx_nov_user_mobile_id_name ON nov_user (mobile, id, name);

-- Aktivierungs-/Token-Workflows.
CREATE INDEX idx_nov_user_activation_lookup ON nov_user (active, activated_at, activation_used_at, activation_expiry);

-- -----------------------------------------------------------------------------
-- NOV_LEVEL
-- -----------------------------------------------------------------------------

-- Join und Filter auf level.
CREATE INDEX idx_nov_level_level ON nov_level (level);

-- -----------------------------------------------------------------------------
-- Verifikation (manuell)
-- -----------------------------------------------------------------------------

-- EXPLAIN SELECT level, nov_mode, MAX(score) AS max_score
-- FROM game
-- WHERE user_id = 123 AND level BETWEEN 1 AND 8 AND nov_mode BETWEEN 1 AND 2
-- GROUP BY level, nov_mode;

-- EXPLAIN SELECT u.id, u.name, nov_level.level, g.score, g.ende
-- FROM nov_user AS u
-- INNER JOIN game AS g ON g.user_id = u.id
-- INNER JOIN nov_level ON g.level = nov_level.level
-- WHERE g.score > 0
--   AND g.score = (
--     SELECT MAX(g1.score)
--     FROM game AS g1
--     WHERE g1.user_id = u.id
--       AND g1.level = nov_level.level
--       AND g1.nov_mode = 1
--       AND g1.beginn > NOW() - INTERVAL 12 MONTH
--   )
--   AND u.mobile = 'N'
--   AND nov_level.level = 1
--   AND g.nov_mode = 1
-- ORDER BY g.score DESC
-- LIMIT 100;
