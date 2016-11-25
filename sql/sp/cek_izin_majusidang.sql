CREATE OR REPLACE FUNCTION pengisian_jadwal_nonsidang()
    RETURNS "trigger" AS
    $$
    DECLARE deadline date;
    BEGIN
        deadline = (SELECT T.tanggal FROM TIMELINE AS T WHERE T.tahun = Extract(year from CURRENT_DATE) AND T.semester = CEILING(Extract(month from CURRENT_DATE) / 6.0) AND T.namaevent = 'Pemberian izin maju Sidang oleh pembimbing');
        IF (CURRENT_DATE > deadline) THEN
            RAISE EXCEPTION 'batas waktu pengisian telah berakhir';
            RETURN NULL;
        END IF;
        RETURN NEW;
    END
    $$ LANGUAGE plpgsql;
