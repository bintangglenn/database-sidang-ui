import random

#SQLInverter
def inserter():
    table = input("Masukkan table: ")
    string = "INSERT INTO {} (".format(table)
    i = "-"
    count = 0
    while(i != ";"):
        att = input("Atribut: ")
        i = att
        if(att != ";"):
            string += att + ","
            count += 1
    string = string[:-1]
    string += ") VALUES ("
    while True:
        outFile = open(table + ".sql", "a")
        tmp = string
        for i in range(count):
            print(i)
            data = input("--> ")
            tmp += "\'{}\',".format(data)
        tmp = tmp[:-1]
        tmp += ");\n"
        outFile.write(tmp)
        outFile.close()

#RandomEmail
def randomEmail():
    string = randomName(5,11)
    string += "@"
    string += randomName(5,11)
    string += "."
    string += random.choice(["com","ac.id","co.id"])
    return string

#RandomDate
def randomDate(x=-1):
    bulan = random.randrange(1,13)
    tgl31 = [1,3,5,7,8,10,12]
    if(bulan in tgl31):
        tgl = random.randrange(1,32)
    elif(bulan == 2):
        tgl = random.randrange(1,29)
    else:
        tgl = random.randrange(1,31)

    if(x == -1):
        tahun = random.randrange(2000,2021)
    else:
        tahun = x

    return "{}-{}-{}".format(tahun,bulan,tgl)

#PairDate
def pairDate(tahun):
    tgl31 = [1,3,5,7,8,10,12]
    bulan1 = random.randrange(1,13)
    if(bulan1 in tgl31):
        if(bulan1 > 9):
            tgl1 = random.randrange(1,16)
            tgl2 = random.randrange(16,32)
            bulan2 = bulan1
        else:
            tgl1 = random.randrange(1,32)
            bulan2 = random.randrange(bulan1 + 1, 13)
            tgl2 = tgl1
    elif(bulan1 == 2):
        tgl1 = random.randrange(1,29)
        bulan2 = random.randrange(bulan1 + 1, 13)
        tgl2 = tgl1
    else:
        tgl1 = random.randrange(1,31)
        bulan2 = random.randrange(bulan1 + 1, 13)
        tgl2 = tgl1

    return "{}-{}-{}".format(tahun,bulan1,tgl1), "{}-{}-{}".format(tahun,bulan2,tgl2)

#PairTime
def pairTime():
    jam1 = random.randrange(9,17)
    jam2 = jam1 + random.randrange(4)
    menit = random.randrange(0,60)

    if(menit < 10):
        menit = "0" + str(menit)

    return "{}:{}".format(jam1,menit),"{}:{}".format(jam2, menit)

#RandomName
def randomName(x,y):
    ranLength = random.randrange(x,y)
    name = ""
    for i in range(ranLength):
        name += random.choice("abcdefghijklmnopqrstuvwxyz ABCDEFGHIJKLMNOPQRSTUVWXYZ ")
    return name

#RandomName2
def randomName2(x,y):
    ranLength = random.randrange(x,y)
    name = ""
    for i in range(ranLength):
        name += random.choice("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ")
    return name

#RandomTelp
def randomTelp():
    string = "08"
    for i in range(10):
        string += str(random.randrange(10))
    return string

#RandomNum
def randomNum(x):
    string = ""
    for i in range(x):
        string += str(random.randrange(10))
    return string

#MATA_KULIAH_SPESIAL
def genMKS(x):
    npm_ = [1506688781,1506688802,1506688930,1506689046,1506689253,1506689267,1506689328,1506689242,1506689151,1506689560,1506689662,1506687963,1506685967,1506689720,1506690613,1506690264,1506721876,1506727933,1506792883,1506730203,1506730038,1506731356,1506732476,1506732987,1506735357,1506736325,1506736253,1506738510,1506738521,1506757241,1506757353,1506754763,1506754764,1506757666,1506757754,1506757980,1506757884,1506757694,1506757926,1506752926,]
    tahun_ = [2011,2012,2013,2014,2015]
    semester_ = [1,2,3]
    outFile = open("MATA_KULIAH_SPESIAL-DATA.sql","w")
    for i in range(x, x + 50):
        npm = npm_[random.randrange(len(npm_))]
        tahun = tahun_[random.randrange(len(tahun_))]
        semester = semester_[random.randrange(len(semester_))]
        judul = randomName(40, 61)
        idJenis = random.randrange(1,10)
        tmp = "INSERT INTO MAHASISWA VALUES ({},\'{}\',{},{},\'{}\',false,false,false,{});\n".format(i, npm, tahun, semester, judul, idJenis)
        outFile.write(tmp)
    outFile.close()

#MAHASISWA
def genMahasiswa():
    uniSet = set()
    npm = randomNum(10)
    outFile = open("MAHASISWA-DATA.sql", "a")
    if(npm not in uniSet):
        uniSet.add(npm)
        nama = randomName2(15,26)
        user = randomName2(5,13)
        passw = randomName2(1,21)
        email = randomEmail()
        email2 = randomEmail()
        telp = randomTelp()
        telp2 = randomTelp()
        tmp = "INSERT INTO MAHASISWA VALUES (\'{}\',\'{}\',\'{}\',\'{}\',\'{}\',\'{}\',\'{}\',\'{}\');\n".format(npm, nama, user, passw, email, email2, telp, telp2)
        outFile.write(tmp)
    outFile.close()

#DOSEN
def genDosen():
    uniSet = set()
    nip = randomNum(10)
    outFile = open("DOSEN-DATA.sql", "a")
    if(nip not in uniSet):
        uniSet.add(nip)
        nama = randomName2(15,26)
        user = randomName2(5,13)
        passw = randomName2(1,21)
        email = randomEmail()
        institusi = randomName(15,30)
        tmp = "INSERT INTO DOSEN VALUES (\'{}\',\'{}\',\'{}\',\'{}\',\'{}\',\'{}\');\n".format(nip, nama, user, passw, email, institusi)
        outFile.write(tmp)
    outFile.close()

#DOSEN_PEMBIMBING
def genDosenPembimbing(x):
    NIPpembimbing = [1445476273, 1135910739, 1301687560, 1464008465, 1466847404, 1121442827, 1343301691, 1119428847, 1218867580, 1497699508, 1281854830, 1297126324, 1252979647, 1189996475, 1269525570, 1419530189, 1328070758, 1230244771, 1278073889, 1283057756]
    outFile = open("DOSEN_PEMBIMBING-DATA.sql", "w")
    i = x
    uniSet = set()
    while(i < x + 60):
        IDMKS = random.randrange(1,81)
        idxNIP = random.randrange(len(NIPpembimbing))
        idx = IDMKS, idxNIP
        if(idx not in uniSet):
            uniSet.add(idx)
            tmp = "INSERT INTO DOSEN_PEMBIMBING (IDMKS, NIPpembimbing) VALUES ({},\'{}\');\n".format(IDMKS, NIPpembimbing[idxNIP])
            outFile.write(tmp)
            i += 1
    outFile.close()
    
#SARAN_DOSEN_PENGUJI
def genSaranDosenPenguji(x):
    NIPsaranpenguji = [1445476273, 1135910739, 1301687560, 1464008465, 1466847404, 1121442827, 1343301691, 1119428847, 1218867580, 1497699508, 1281854830, 1297126324, 1252979647, 1189996475, 1269525570, 1419530189, 1328070758, 1230244771, 1278073889, 1283057756]
    outFile = open("SARAN_DOSEN_PENGUJI-DATA.sql", "w")
    i = x
    uniSet = set()
    while(i < x + 50):
        IDMKS = random.randrange(1,81)
        idxNIP = random.randrange(len(NIPsaranpenguji))
        idx = IDMKS, idxNIP
        if(idx not in uniSet):
            uniSet.add(idx)
            tmp = "INSERT INTO SARAN_DOSEN_PENGUJI (IDMKS, NIPsaranpenguji) VALUES ({},\'{}\');\n".format(IDMKS, NIPsaranpenguji[idxNIP])
            outFile.write(tmp)
            i += 1
    outFile.close()

#DOSEN_PENGUJI
def genDosenPenguji(x):
    NIPdosenpenguji = [1445476273, 1135910739, 1301687560, 1464008465, 1466847404, 1121442827, 1343301691, 1119428847, 1218867580, 1497699508, 1281854830, 1297126324, 1252979647, 1189996475, 1269525570, 1419530189, 1328070758, 1230244771, 1278073889, 1283057756]
    outFile = open("DOSEN_PENGUJI-DATA.sql", "w")
    i = x
    uniSet = set()
    while(i < x + 60):
        IDMKS = random.randrange(1,81)
        idxNIP = random.randrange(len(NIPdosenpenguji))
        idx = IDMKS, idxNIP
        if(idx not in uniSet):
            uniSet.add(idx)
            tmp = "INSERT INTO DOSEN_PENGUJI (IDMKS, NIPdosenpenguji) VALUES ({},\'{}\');\n".format(IDMKS, NIPdosenpenguji[idxNIP])
            outFile.write(tmp)
            i += 1
    outFile.close()

#TIMELINE
def genTimeline(x):
    tahun = [2011,2012,2013,2014,2015]
    semester = [1,2,3]
    outFile = open("TIMELINE-DATA.sql", "w")
    for i in range(x, x + 20):
        namaEvent = randomName(10,101)
        tahunInserted = tahun[random.randrange(len(tahun))]
        smsInserted = semester[random.randrange(len(semester))]
        tanggal = randomDate(tahunInserted)
        tmp = "INSERT INTO TIMELINE (IdTimeline, NamaEvent, Tanggal, Tahun, Semester) VALUES ({},\'{}\',\'{}\',{},{});\n".format(i, namaEvent, tanggal, tahunInserted, smsInserted)
        outFile.write(tmp)
    outFile.close()

#JADWAL_NON_SIDANG
def genJadwalNonSidang(x):
    NIPdosen = [1445476273, 1135910739, 1301687560, 1464008465, 1466847404, 1121442827, 1343301691, 1119428847, 1218867580, 1497699508, 1281854830, 1297126324, 1252979647, 1189996475, 1269525570, 1419530189, 1328070758, 1230244771, 1278073889, 1283057756]
    outFile = open("JADWAL_NON_SIDANG-DATA.sql", "w")
    repData = ["null", "harian", "mingguan", "bulanan"]
    for i in range(x, x + 50):
        tglMulai, tglSelesai = pairDate(2016) #Default
        alasan = randomName(50,101)
        repetisi = random.choice(repData)
        idxNip = random.randrange(len(NIPdosen))
        tmp = "INSERT INTO JADWAL_NON_SIDANG (IdJadwal, Tanggalmulai, Tanggalselesai, Alasan, Repetisi, NIPdosen) VALUES "
        if(repetisi == "null"):
            tmp += "({},\'{}\',\'{}\',\'{}\',null,\'{}\');\n".format(i, tglMulai, tglSelesai, alasan, idxNip)
        else:
            tmp += "({},\'{}\',\'{}\',\'{}\',\'{}\',\'{}\');\n".format(i, tglMulai, tglSelesai, alasan, repetisi, idxNip)
        outFile.write(tmp)
    outFile.close()

#RUANGAN
def genRuangan(x):
    uniSet = set() #to make sure unique
    i = x
    outFile = open("RUANGAN-DATA.sql", "w")
    while(i < x + 20):
        namaRuangan = randomName(8,21)
        if(namaRuangan not in uniSet):
            uniSet.add(namaRuangan)
            tmp = "INSERT INTO RUANGAN (IDRuangan, NamaRuangan) VALUES ({},\'{}\');\n".format(i, namaRuangan)
            outFile.write(tmp)
            i += 1
    outFile.close()

#JADWAL_SIDANG
def genJadwalSidang(x):
    outFile = open("JADWAL_SIDANG-DATA.sql", "w")
    for i in range(x, x + 50):
        idMKS = random.randrange(1,81)
        tanggal = randomDate(random.choice([2011,2012,2013,2014,2015]))
        jamMulai, jamSelesai = pairTime()
        idRuangan = random.randrange(1,35)
        tmp = "INSERT INTO JADWAL_SIDANG (IDJadwal, Tanggal, JamMulai, JamSelesai, IdRuangan) VALUES ({},{},\'{}\',\'{}\',\'{}\',{});\n".format(i,idMKS, tanggal, jamMulai, jamSelesai, idRuangan)
        outFile.write(tmp)
    outFile.close()

#BERKAS
def genBerkas(x):
    outFile = open("BERKAS-DATA.sql", "w")
    for i in range(x, x + 100):
        idMKS = random.randrange(1,81)
        nama = randomName(12,31)
        alamat = randomName(25,101)
        tmp = "INSERT INTO BERKAS (IDBerkas, IdMKS, Nama, Alamat) VALUES ({},{},\'{}\',\'{}\');\n".format(i, idMKS, nama, alamat)
        outFile.write(tmp)
    outFile.close()
