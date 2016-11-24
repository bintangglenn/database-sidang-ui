CREATE OR REPLACE FUNCTION auto_siap_sidang()
    RETURNS "trigger" AS
    $$
    BEGIN
        IF (TG_OP = 'INSERT') THEN
            IF (NEW.IsSiapSidang) THEN
                RETURN NEW;
            END IF;
            IF (NEW.PengumpulanHardCopy = true AND NEW.IjinMajuSidang = true) THEN
                NEW.IsSiapSidang = true;
            END IF;
            RETURN NEW;
        ELSEIF (TG_OP = 'UPDATE') THEN
            IF (OLD.PengumpulanHardCopy = true AND OLD.IjinMajuSidang = true) THEN
                OLD.IsSiapSidang = true;
            END IF;
            RETURN OLD;
        END IF;
    END
    $$ LANGUAGE plpgsql;
