����֧��-��С�������ֻ���ҳ��Ӧ��֧��ҵ�����ָ��

2014-08-21

==== ����Ҫ�� ====

    JDK 1.5�����ϰ汾


==== �ļ��ṹ ====

<cpgatetest>
  ��
  ��src�����������������������������������ļ���
  ��  ��
  ��  ��com.ipaynow.filter
  ��  ��  ��
  ��  ��  ��CharacterEncodingFilter.java������������Web�ַ�������
  ��  ��
  ��  ��com.ipaynow.utils
  ��  ��  ��
  ��  ��  ��FormDateReportConvertor.java������ �������ͱ�������ת����
  ��  ��  ��
  ��  ��  ��HttpClientUtil.java����������HttpЭ��ͻ��˹�����
  ��  ��  ��
  ��  ��  ��MD5.java�������� MD5���ܻ���������
  ��  ��  ��
  ��  ��  ��MD5Facade.java���������� MD5����ӿڹ���
  ��  ��
  ��  ��com.ipaynow.pay
  ��  ��  ��
   |   |   |---OrderServlet.java----------------ģ���̻�������Ϣ��дҳ��
   |   |   | 
   |   |   |---ToPayServlet.java---------------- �̻�����ȷ����֧������ǩ��Servlet
   |   |   
   |   |---com.ipaynow.notify
   |   |    |
   |   |    |---MchFrontNotifyServlet.java--------------- �̻���������֧�����������ǰ��֧�����֪ͨ��Servlet
   |   |    |
   |   |    |---MchBackNotifyServlet.java----------------�̻���������֧�����������첽ͨѶ֪ͨ��Servlet 
   |   | 
   |   |---com.ipaynow.query
   |   |    |
   |   |    |---MchQuery.java-------�̻�������֧�����𶩵���Ϣ��״̬��ѯ��Demo
  ��      
  ��
  ��WebRoot������������������������������WEB���� ����ֱ�ӷ���Tomcat�Ͻ������в鿴Ч��
      ��  
      ��
      ��WEB-INF
      |   |
      |   |-lib�����JAVA��Ŀ�а�����Щjar��������Ҫ���룩
      |   |  ��
      |   |  ��commons-logging-1.1.1.jar
      |   |  ��
      |   |  ��httpclient-4.1.2.jar
      |   |  ��
      |   |  ��httpcore-4.1.2.jar| 
      |   |
      |   |-web.xml ------�������ַ���������  �̻���������֧��֪ͨ��Servlet
      |     
      |------ order.jsp -------����ģ���̻�����ҳ��
      |
      |------ topay.jsp -------�˽ӿ���Ϊ�ؼ����Ǿۺ�֧���ӿڵĲ���Form��
      | 
      |------ frontNotify.jsp ----ǰ��֪ͨ���պ����ʾҳ�� 
  


==== ע������ ====

    ��Demo�йؼ���Java����������1.ToPay.java  ----�������в���������ǩ���ֶε�ǩ������  Ϊ֧����������ƴ����
                                2.MchFrontNotifyServlet.java ---����Ϊǰ̨֪ͨ�Ľ����� ��Servlet��urlһ����topay.jsp��ǰ̨֪ͨurl
                                3.MchBackNotifyServlet.java ---����Ϊ��̨֪ͨ�Ľ�����

    ��Demo�йؼ���ҳ����һ����  topay.jsp  ---form��url������֧�������Ͻӿ�url��  �����ݼ��Ǳ�Ҫ���� 

    ������ʾ���л�ȡԶ��HTTP��Ϣʹ�õ���httpclient-4.1.2 �汾�ĵ�����jar����
    ���������ʹ�ø÷�ʽʵ�ֻ�ȡԶ��HTTP���ܣ�����������ʽ�������ʱ�������б�д���롣

