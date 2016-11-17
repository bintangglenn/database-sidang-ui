import random

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

    return "{}-{}-{}".format(tgl,bulan,tahun)

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

    return "{}-{}-{}".format(tgl1,bulan1,tahun), "{}-{}-{}".format(tgl2,bulan2,tahun)

#PairTime
def pairTime:
    jam1 = random.randrange(9,17)
    jam2 = jam1 + random.randrange(4)
    menit = random.randrange(0,60)

    if(menit < 10):
        menit = "0" + menit

    return "{}:{}".format(jam1,menit),"{}:{}".format(jam2, menit)

#RandomName
def randomName(x,y):
    ranLength = random.randrange(x,y)
    name = ""
    for i in range(ranLength):
        name += random.choice("abcdefghijklmnopqrstuvwxyz ABCDEFGHIJKLMNOPQRSTUVWXYZ ")
    return name
    
#SARAN_DOSEN_PENGUJI
def genSaranDosenPenguji():
    IDMKS_MKS = []
    NIPsaranpenguji = []
    outFile = open("SARAN_DOSEN_PENGUJI-DATA.txt", "w")
    i = 0
    uniSet = set()
    while(i < 50):
        idx = random.randrange(len(IDMKS_MKS)), random.randrange(len(NIPsaranpenguji))
        if(idx not it uniSet):
            uniSet.add(idx)
            tmp = "INSERT INTO SARAN_DOSEN_PENGUJI (IDMKS, NIPsaranpenguji) VALUES ({},\'{}\');\n".format(IDMKS_MKS[idxIDMKS], NIPsaranpenguji[idxNIP])
            outFile.write(tmp)
            i += 1
    outFile.close()

#DOSEN_PENGUJI
def genDosenPenguji():
    IDMKS_MKS = []
    NIPdosenpenguji = []
    outFile = open("DOSEN_PENGUJI-DATA.txt", "w")
    i = 0
    uniSet = set()
    while(i < 60):
        idx = random.randrange(len(IDMKS_MKS)), random.randrange(len(NIPdosenpenguji))
        if(idx not it uniSet):
            uniSet.add(idx)
            tmp = "INSERT INTO DOSEN_PENGUJI (IDMKS, NIPdosenpenguji) VALUES ({},\'{}\');\n".format(IDMKS_MKS[idxIDMKS], NIPdosenpenguji[idxNIP])
            outFile.write(tmp)
            i += 1
    outFile.close()

#TIMELINE
def genTimeline():
    tahun = []
    semester = []
    outFile = open("TIMELINE-DATA.txt", "w")
    for i in range(1, 21):
        namaEvent = randomName(10,101)
        tahunInserted = tahun[random.randrange(len(tahun))]
        smsInserted = semester[random.randrange(len(semester))]
        tanggal = randomDate(tahunInserted)
        tmp = "INSERT INTO TIMELINE (IdTimeline, NamaEvent, Tanggal, Tahun, Semester) VALUES ({},\'{}\',\'{}\',\'{}\',\'{}\');\n".format(i, namaEvent, tanggal, tahunInserted, semesterInserted)
        outFile.write(tmp)
    outFile.close()

#JADWAL_NON_SIDANG
def genJadwalNonSidang():
    NIPdosen = []
    outFile = open("JADWAL_NON_SIDANG-DATA.txt", "w")
    repData = ["null", "harian", "mingguan", "bulanan"]
    for i in range(1, 51):
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
def genRuangan():
    uniSet = set() #to make sure unique
    while(i < 20):
        namaRuangan = randomName(8,21)
        if(namaRuangan not in uniSet):
            uniSet.add(namaRuangan)
            tmp = "INSERT INTO RUANGAN (IDRuangan, NamaRuangan) VALUES ({},\'{}\');\n)".format(i, namaRuangan)
            outFile.write(tmp)
            i += 1
    outFile.close()
