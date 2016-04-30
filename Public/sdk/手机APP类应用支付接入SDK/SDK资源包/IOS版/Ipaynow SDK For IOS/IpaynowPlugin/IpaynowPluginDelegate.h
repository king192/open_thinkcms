//
//  IpaynowPluginDelegate.h
//  TestIpaynow
//
//  Created by dby on 14-8-17.
//  Copyright (c) 2014年 Ipaynow. All rights reserved.
//

#import <Foundation/Foundation.h>

@protocol IpaynowPluginDelegate <NSObject>
-(void)IpaynowPluginResult:(NSString*)result;
@end
