//
//  MainViewController.m
//  TestIpaynow
//
//  Created by dby on 14-8-16.
//  Copyright (c) 2014年 Ipaynow. All rights reserved.
//

#import "MainViewController.h"
#import "IPNPreSignMessageUtil.h"


#include <sys/socket.h>
#include <sys/sysctl.h>
#include <net/if.h>
#include <net/if_dl.h>
#import "IpaynowPluginApi.h"
#import <CoreFoundation/CoreFoundation.h>

#define KBtn_width        200
#define KBtn_height       80
#define KXOffSet          (self.view.frame.size.width - KBtn_width) / 2
#define KYOffSet          80

#define kVCTitle          @"支付测试"
#define kBtnFirstTitle    @"获取订单，开始支付"
#define kWaiting          @"正在获取订单,请稍候..."
#define kNote             @"提示"
#define kConfirm          @"确定"
#define kErrorNet         @"网络错误"
#define kResult           @"支付结果："

#define kOrderUrl      @"http://yuyangnews.ipaynow.cn/ZyPluginPaymentTest_PAY/api/pay.php"
#define kSignURL       @"http://yuyangnews.ipaynow.cn/ZyPluginPaymentTest_PAY/api/pay2.php"

@implementation MainViewController
{
    NSString *_presignStr;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view, typically from a nib.
    
    self.view.backgroundColor = [UIColor whiteColor];
    self.title = kVCTitle;

	// Do any additional setup after loading the view, typically from a nib.
    
    // Add the normalTn button
    CGFloat y = KYOffSet;
    UIButton* btnStartPay = [UIButton buttonWithType:UIButtonTypeRoundedRect];
    [btnStartPay setTitle:kBtnFirstTitle forState:UIControlStateNormal];
    [btnStartPay addTarget:self action:@selector(payAction:) forControlEvents:UIControlEventTouchUpInside];
    [btnStartPay setFrame:CGRectMake(KXOffSet, y, KBtn_width, KBtn_height)];
    
    [self.view addSubview:btnStartPay];
}

- (void)showAlertMessage:(NSString*)msg
{
    mAlert = [[UIAlertView alloc] initWithTitle:kNote message:msg delegate:nil cancelButtonTitle:kConfirm otherButtonTitles:nil, nil];
    [mAlert show];
}

-(void)payAction:(UIButton *)sender{
    NSDateFormatter *dateFormatter = [[NSDateFormatter alloc] init];
    [dateFormatter setDateFormat:@"yyyyMMddHHmmss"];
    
    IPNPreSignMessageUtil *preSign=[[IPNPreSignMessageUtil alloc]init];
    preSign.appID=@"1410922746865447";
    preSign.mhtOrderNo=[dateFormatter stringFromDate:[NSDate date]];
    preSign.mhtOrderName=@"手机插件测试用例";
    preSign.mhtOrderType=@"01";
    preSign.mhtCurrencyType=@"156";
    preSign.mhtOrderAmt=@"100";
    preSign.mhtOrderDetail=@"关于订单验证接口的测试";
    preSign.mhtorderStartTime=[dateFormatter stringFromDate:[NSDate date]];
    preSign.notifyUrl=@"http://localhost:10802/";
    preSign.mhtCharset=@"UTF-8";
    preSign.mhtOrderTimeOut=@"3600";
    preSign.mhtReserved=@"test";
    preSign.consumerId=@"IPN00001";
    preSign.consumerName=@"IpaynowCS";
    //preSign.payChannelType=@"11";
    
    NSString *originStr=[preSign generatePresignMessage];
    _presignStr= originStr;
    
    NSString *outputStr = (NSString *)
    CFBridgingRelease(CFURLCreateStringByAddingPercentEscapes(kCFAllocatorDefault,
                                            (CFStringRef)originStr,
                                            NULL,
                                            (CFStringRef)@"!*'();:@&=+$,/?%#[]",
                                            kCFStringEncodingUTF8));
    
    
    
    NSString *presignStr=@"paydata=";
    presignStr=[presignStr stringByAppendingString:outputStr];
    
    NSURL* url = [NSURL URLWithString:kSignURL];
    NSMutableURLRequest * urlRequest=[NSMutableURLRequest requestWithURL:url];
    [urlRequest setHTTPMethod:@"POST"];
    urlRequest.HTTPBody=[presignStr dataUsingEncoding:NSUTF8StringEncoding];
    NSURLConnection* urlConn = [[NSURLConnection alloc] initWithRequest:urlRequest delegate:self];
    [urlConn start];
    [self showAlertWait];
}

- (void)connection:(NSURLConnection *)connection didReceiveResponse:(NSURLResponse*)response {
    NSHTTPURLResponse* rsp = (NSHTTPURLResponse*)response;
    int code = (int)[rsp statusCode];
    if (code != 200) {
    } else {
        if (mData != nil) {
            mData = nil;
        }
        mData = [[NSMutableData alloc] init];
    }
}

- (void)connection:(NSURLConnection *)connection didReceiveData:(NSData *)data {
    [mData appendData:data];
}

- (void)connectionDidFinishLoading:(NSURLConnection *)connection {
    [self hideAlert];
    NSString* data = [[NSMutableString alloc] initWithData:mData encoding:NSUTF8StringEncoding];
    NSString* payData=[_presignStr stringByAppendingString:@"&"];
    payData=[payData stringByAppendingString:data];
    [IpaynowPluginApi pay:payData AndScheme:@"IpaynowPluginDemo" viewController:self delegate:self];
   
}

-(void)connection:(NSURLConnection *)connection didFailWithError:(NSError *)error {
    [self hideAlert];
    [self showAlertMessage:kErrorNet];
}

-(void)IpaynowPluginResult:(NSString*)result{
    NSMutableString *resultString = [[NSMutableString alloc] initWithString:kResult];
    [resultString appendString:result];
    UIAlertView* alert = [[UIAlertView alloc] initWithTitle:kNote
                                                    message:resultString
                                                   delegate:nil
                                          cancelButtonTitle:kConfirm
                                          otherButtonTitles:nil];
    [alert show];
}

- (void)showAlertWait {
    mAlert = [[UIAlertView alloc] initWithTitle:kWaiting message:nil delegate:self cancelButtonTitle:nil otherButtonTitles: nil];
    [mAlert show];
    UIActivityIndicatorView* aiv = [[UIActivityIndicatorView alloc] initWithActivityIndicatorStyle:UIActivityIndicatorViewStyleWhite];
    aiv.center = CGPointMake(mAlert.frame.size.width / 2.0f - 15, mAlert.frame.size.height / 2.0f + 10 );
    [aiv startAnimating];
    [mAlert addSubview:aiv];
}

- (void)hideAlert {
    if (mAlert != nil)
    {
        [mAlert dismissWithClickedButtonIndex:0 animated:YES];
        mAlert = nil;
    }
}

@end
