@extends('home')

@section('contenido')
	<template v-if="menu==0">
	    <dashboard></dashboard>
	</template>
	<template v-if="menu==1">
		<institucion></institucion>    
	</template>
	<template v-if="menu==2">
	    <tipo-institucion></tipo-institucion>
	</template>	
	<template v-if="menu==3">
	    <rama></rama>
	</template>	
	<template v-if="menu==4">
	    <estado></estado>
	</template>
	<template v-if="menu==5">
	    <cargo></cargo>
	</template>	
	<template v-if="menu==6">
	    <empleado></empleado>
	</template>
	<template v-if="menu==7">
	    <ausencia></ausencia>
	</template>	
	<template v-if="menu==8">
	    <objetivo></objetivo>
	</template>	
	<template v-if="menu==9">
	    <curso></curso>
	</template>
	<template v-if="menu==10">
	    <cuestionario></cuestionario>
	</template>	
	<template v-if="menu==11">
	    <usuario></usuario>
	</template>		
@endsection