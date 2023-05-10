CREATE TABLE IF NOT EXISTS log_levels (
    log_level_id INTEGER PRIMARY KEY,
    log_level_name VARCHAR(10) NOT NULL
);

INSERT INTO log_levels (log_level_id, log_level_name) VALUES
    (0, 'INFO'),
    (1, 'CRITICAL'),
    (2, 'WARNING');

CREATE TABLE IF NOT EXISTS logs (
    log_id INTEGER PRIMARY KEY AUTOINCREMENT,
    log_level_id INTEGER NOT NULL DEFAULT 0,
    log_source VARCHAR NOT NULL, -- This will be a unix path '/path/to/script'
    log_message TEXT NOT NULl,
    log_entry_timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (log_level_id) REFERENCES log_levels(log_level_id)
);


CREATE VIEW IF NOT EXISTS log_statistics AS
    SELECT levels.log_level_name, COUNT(logs.log_id) FROM logs
    JOIN log_levels levels ON log_levels.log_level_id = logs.log_level_id
    GROUP BY logs.log_level_id;

CREATE VIEW IF NOT EXISTS log_statistics_last_7_days AS
    SELECT log_levels.log_level_name, COUNT(logs.log_id) FROM logs
    JOIN log_levels ON log_levels.log_level_id = logs.log_level_id 
    WHERE logs.log_entry_timestamp > DATETIME(CURRENT_TIMESTAMP, '-7 day')
    GROUP BY logs.log_level_id;