CREATE OR REPLACE FUNCTION auto_siap_sidang()
    RETURNS "trigger" AS
    $$
    BEGIN
        IF (TG_OP = 'UPDATE') THEN
            IF (NEW.IsSiapSidang = true) THEN
                RETURN NULL;
            ELSEIF (NEW.PengumpulanHardCopy = true AND NEW.IjinMajuSidang = true) THEN
                UPDATE MATA_KULIAH_SPESIAL
                SET IsSiapSidang = true WHERE idmks = NEW.idmks;
            END IF;
            RETURN NEW;
        END IF;
    END
    $$ LANGUAGE plpgsql;
