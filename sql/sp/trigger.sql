CREATE OR REPLACE FUNCTION auto_siap_sidang() {
    RETURNS triggers AS
    $$
    BEGIN
        IF (TG_OP = "INSERT") THEN
            IF (NEW.PengumpulanHardCopy = true AND NEW.IjinMajuSidang = true) THEN
                NEW.IsSiapSidang = true
            END IF
        ELSEIF (TG_OP = "UPDATE") THEN
            IF (OLD.PengumpulanHardCopy = true AND OLD.IjinMajuSidang = true) THEN
                OLD.IsSiapSidang = true
            END IF
        END IF;
    END
    $$
}
