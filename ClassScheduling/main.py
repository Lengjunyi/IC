f = open("data.in")
Students = []
Courselist = []
for i in range(43):
    A = list(f.readline().strip("\n").split("	"))
    while '' in A:
        A.remove('')
    for j in range(len(A)):
        if A[j] not in Courselist:
            Courselist.append(A[j])
        A[j] = Courselist.index(A[j])
    Students.append(A)

natural_distribution = [0 for i in range(6)]
for i in Students:
    natural_distribution[len(i)] +=1
print(natural_distribution)
num = 0


Answers = [] #[[course_distribution, student_distribution]]
for i in range(11):
    for ii in range(i,10):
        for iii in range(9):
            for iv in range(iii,8):
                for v in range(iv,7):
                    for vi in range(6):
                        for vii in range(vi,5):
                            for viii in range(vii,4):
                                num +=1
                                print(str(num)+"/90000+ 请耐心等待")
                                Total_course = [k for k in range(11)]
                                Course_distribution = []
                                Course_distribution.append([Total_course.pop(i),Total_course.pop(ii)])
                                Course_distribution.append([Total_course.pop(iii), Total_course.pop(iv),Total_course.pop(v)])
                                Course_distribution.append([Total_course.pop(vi), Total_course.pop(vii),Total_course.pop(viii)])
                                Course_distribution.append(Total_course)

                                course_available_distribution = [0,0,0,0,0,0]
                                for student in Students:
                                    courses_available_to_me = 0
                                    for period in Course_distribution:
                                        if (period[0] in student or period[1] in student or (False if len(period)==2 else period[2] in student)):
                                            courses_available_to_me +=1
                                    course_available_distribution[courses_available_to_me] +=1
                                    #print(course_available_distribution)

                                k=0
                                worsened = False
                                while(k<len(Answers)):
                                    old_solution = Answers[k][1]
                                    better = 0
                                    worse = 0
                                    old_total = 0
                                    new_total = 0
                                    for m in range(6):
                                        old_total+=old_solution[6-m-1]
                                        new_total+=course_available_distribution[6-m-1]
                                        if new_total>old_total:
                                            better +=1
                                        elif new_total<old_total:
                                            worse +=1
                                        if better*worse>1:
                                            break
                                    if better>0 and worse==0:
                                        Answers.pop(k)
                                    if better==0 and worse>0:
                                        worsened = True
                                        break
                                    if better==0 and worse ==0:
                                        worsened = True
                                    k+=1
                                if not worsened:
                                    Answers.append([Course_distribution,course_available_distribution])
                                #print(Answers)
print(Answers)



Course_List = Courselist
ind = 0
for (i) in Answers:
    Course_set = i[0]
    Distribution = i[1]
    print("第"+str(ind+1)+"种选法：")
    ind+=1
    index = 0
    for (j) in Course_set:
        index+=1
        print("Period "+str(index)+":", end=" ")
        for k in j:
            print(Course_List[k], end=" ")
        print("")
    print(Distribution)
    print("")

print("备注：")
print("初始意向选课数量分布：",end=" ")
print(natural_distribution)
