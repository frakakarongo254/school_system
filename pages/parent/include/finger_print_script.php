<script type="text/javascript">
	
        var flag =0;
        var quality = 60; //(1 to 100) (recommanded minimum 55)
        var timeout = 10; // seconds (minimum=10(recommanded), maximum=60, unlimited=0 )

//function to initialize the device

        function GetInfo() {
            document.getElementById('tdSerial').innerHTML = "";
            document.getElementById('tdCertification').innerHTML = "";
            document.getElementById('tdMake').innerHTML = "";
            document.getElementById('tdModel').innerHTML = "";
            document.getElementById('tdWidth').innerHTML = "";
            document.getElementById('tdHeight').innerHTML = "";
            document.getElementById('tdLocalMac').innerHTML = "";
            document.getElementById('tdLocalIP').innerHTML = "";
            document.getElementById('tdSystemID').innerHTML = "";
            document.getElementById('tdPublicIP').innerHTML = "";


            var key = document.getElementById('txtKey').value;

            var res;
            if (key.length == 0) {
                res = GetMFS100Info();
            }
            else {
                res = GetMFS100KeyInfo(key);
            }

            if (res.httpStaus) {

                document.getElementById('txtStatus').value = "ErrorCode: " + res.data.ErrorCode + " ErrorDescription: " + res.data.ErrorDescription;

                if (res.data.ErrorCode == "0") {
                    document.getElementById('tdSerial').innerHTML = res.data.DeviceInfo.SerialNo;
                    document.getElementById('tdCertification').innerHTML = res.data.DeviceInfo.Certificate;
                    document.getElementById('tdMake').innerHTML = res.data.DeviceInfo.Make;
                    document.getElementById('tdModel').innerHTML = res.data.DeviceInfo.Model;
                    document.getElementById('tdWidth').innerHTML = res.data.DeviceInfo.Width;
                    document.getElementById('tdHeight').innerHTML = res.data.DeviceInfo.Height;
                    document.getElementById('tdLocalMac').innerHTML = res.data.DeviceInfo.LocalMac;
                    document.getElementById('tdLocalIP').innerHTML = res.data.DeviceInfo.LocalIP;
                    document.getElementById('tdSystemID').innerHTML = res.data.DeviceInfo.SystemID;
                    document.getElementById('tdPublicIP').innerHTML = res.data.DeviceInfo.PublicIP;
                }
            }
            else {
                alert(res.err);
            }
            return false;
        }
//function to capture the finger prints. 

        function Capture() {
            try {
                document.getElementById('txtStatus').value = "";
                document.getElementById('imgFinger').src = "data:image/bmp;base64,";
                document.getElementById('txtImageInfo').value = "";
                document.getElementById('txtIsoTemplate').value = "";
                document.getElementById('txtAnsiTemplate').value = "";
                document.getElementById('txtIsoImage').value = "";
                document.getElementById('txtRawData').value = "";
                document.getElementById('txtWsqData').value = "";

                var res = CaptureFinger(quality, timeout);
                if (res.httpStaus) {
                      flag = 1;
                    document.getElementById('txtStatus').value = "ErrorCode: " + res.data.ErrorCode + " ErrorDescription: " + res.data.ErrorDescription;

                    if (res.data.ErrorCode == "0") {
                        document.getElementById('imgFinger').src = "data:image/bmp;base64," + res.data.BitmapData;
                        var imageinfo = "Quality: " + res.data.Quality + " Nfiq: " + res.data.Nfiq + " W(in): " + res.data.InWidth + " H(in): " + res.data.InHeight + " area(in): " + res.data.InArea + " Resolution: " + res.data.Resolution + " GrayScale: " + res.data.GrayScale + " Bpp: " + res.data.Bpp + " WSQCompressRatio: " + res.data.WSQCompressRatio + " WSQInfo: " + res.data.WSQInfo;
                        document.getElementById('txtImageInfo').value = imageinfo;
                        document.getElementById('txtIsoTemplate').value = res.data.IsoTemplate;
                        document.getElementById('txtAnsiTemplate').value = res.data.AnsiTemplate;
                        document.getElementById('txtIsoImage').value = res.data.IsoImage;
                        document.getElementById('txtRawData').value = res.data.RawData;
                        document.getElementById('txtWsqData').value = res.data.WsqImage;
                    }
                }
                else {
                    alert(res.err+"trying");
                }
            }
            catch (e) {
                alert(e+"failed");
            }
            return false;
        }

        function Verify() {
            try {
                var isotemplate = document.getElementById('txtIsoTemplate').value;
                var res = VerifyFinger(isotemplate, isotemplate);

                if (res.httpStaus) {
                    if (res.data.Status) {
                        alert("Finger matched");
                    }
                    else {
                        if (res.data.ErrorCode != "0") {
                            alert(res.data.ErrorDescription);
                        }
                        else {
                            alert("Finger not matched");
                        }
                    }
                }
                else {
                    alert(res.err);
                }
            }
            catch (e) {
                alert(e);
            }
            return false;

        }

        function Match() {
            try {
                var isotemplate = document.getElementById('txtIsoTemplate').value;
                var res = MatchFinger(quality, timeout, isotemplate);

                if (res.httpStaus) {
                    if (res.data.Status) {
                        alert("Finger matched");
                    }
                    else {
                        if (res.data.ErrorCode != "0") {
                            alert(res.data.ErrorDescription);
                        }
                        else {
                            alert("Finger not matched");
                        }
                    }
                }
                else {
                    alert(res.err);
                }
            }
            catch (e) {
                alert(e);
            }
            return false;

        }

        function GetPid() {
            try {
                var isoTemplateFMR = document.getElementById('txtIsoTemplate').value;
                var isoImageFIR = document.getElementById('txtIsoImage').value;

                var Biometrics = Array(); // You can add here multiple FMR value
                Biometrics["0"] = new Biometric("FMR", isoTemplateFMR, "UNKNOWN", "", "");

                var res = GetPidData(Biometrics);
                if (res.httpStaus) {
                    if (res.data.ErrorCode != "0") {
                        alert(res.data.ErrorDescription);
                    }
                    else {
                        document.getElementById('txtPid').value = res.data.PidData.Pid
                        document.getElementById('txtSessionKey').value = res.data.PidData.Sessionkey
                        document.getElementById('txtHmac').value = res.data.PidData.Hmac
                        document.getElementById('txtCi').value = res.data.PidData.Ci
                        document.getElementById('txtPidTs').value = res.data.PidData.PidTs
                    }
                }
                else {
                    alert(res.err);
                }

            }
            catch (e) {
                alert(e);
            }
            return false;
        }
        function GetProtoPid() {
            try {
                var isoTemplateFMR = document.getElementById('txtIsoTemplate').value;
                var isoImageFIR = document.getElementById('txtIsoImage').value;

                var Biometrics = Array(); // You can add here multiple FMR value
                Biometrics["0"] = new Biometric("FMR", isoTemplateFMR, "UNKNOWN", "", "");

                var res = GetProtoPidData(Biometrics);
                if (res.httpStaus) {
                    if (res.data.ErrorCode != "0") {
                        alert(res.data.ErrorDescription);
                    }
                    else {
                        document.getElementById('txtPid').value = res.data.PidData.Pid
                        document.getElementById('txtSessionKey').value = res.data.PidData.Sessionkey
                        document.getElementById('txtHmac').value = res.data.PidData.Hmac
                        document.getElementById('txtCi').value = res.data.PidData.Ci
                        document.getElementById('txtPidTs').value = res.data.PidData.PidTs
                    }
                }
                else {
                    alert(res.err);
                }

            }
            catch (e) {
                alert(e);
            }
            return false;
        }
        function GetRbd() {
            try {
                var isoTemplateFMR = document.getElementById('txtIsoTemplate').value;
                var isoImageFIR = document.getElementById('txtIsoImage').value;

                var Biometrics = Array();
                Biometrics["0"] = new Biometric("FMR", isoTemplateFMR, "LEFT_INDEX", 2, 1);
                Biometrics["1"] = new Biometric("FMR", isoTemplateFMR, "LEFT_MIDDLE", 2, 1);
                // Here you can pass upto 10 different-different biometric object.


                var res = GetRbdData(Biometrics);
                if (res.httpStaus) {
                    if (res.data.ErrorCode != "0") {
                        alert(res.data.ErrorDescription);
                    }
                    else {
                        document.getElementById('txtPid').value = res.data.RbdData.Rbd
                        document.getElementById('txtSessionKey').value = res.data.RbdData.Sessionkey
                        document.getElementById('txtHmac').value = res.data.RbdData.Hmac
                        document.getElementById('txtCi').value = res.data.RbdData.Ci
                        document.getElementById('txtPidTs').value = res.data.RbdData.RbdTs
                    }
                }
                else {
                    alert(res.err);
                }

            }
            catch (e) {
                alert(e);
            }
            return false;
        }

        function GetProtoRbd() {
            try {
                var isoTemplateFMR = document.getElementById('txtIsoTemplate').value;
                var isoImageFIR = document.getElementById('txtIsoImage').value;

                var Biometrics = Array();
                Biometrics["0"] = new Biometric("FMR", isoTemplateFMR, "LEFT_INDEX", 2, 1);
                Biometrics["1"] = new Biometric("FMR", isoTemplateFMR, "LEFT_MIDDLE", 2, 1);
                // Here you can pass upto 10 different-different biometric object.


                var res = GetProtoRbdData(Biometrics);
                if (res.httpStaus) {
                    if (res.data.ErrorCode != "0") {
                        alert(res.data.ErrorDescription);
                    }
                    else {
                        document.getElementById('txtPid').value = res.data.RbdData.Rbd
                        document.getElementById('txtSessionKey').value = res.data.RbdData.Sessionkey
                        document.getElementById('txtHmac').value = res.data.RbdData.Hmac
                        document.getElementById('txtCi').value = res.data.RbdData.Ci
                        document.getElementById('txtPidTs').value = res.data.RbdData.RbdTs
                    }
                }
                else {
                    alert(res.err);
                }

            }
            catch (e) {
                alert(e);
            }
            return false;
        }
       
        function validateform()
        {

        var password1=document.myform.exampleInputPassword1;
        var email=document.myform.exampleInputEmail1.value;
        
        if(email.length>20)
        {
            alert("username can be max 25 char");
            return false;
        }

        if (password1.length>8) 
        {
          alert("password should be max 8 char");
          return false;
        }

        // password matching
        if (password1==password2) 
        {
          return true;
        }
        else
         {
            alert("password not matched");
            return false;
         } 

        }
</script>